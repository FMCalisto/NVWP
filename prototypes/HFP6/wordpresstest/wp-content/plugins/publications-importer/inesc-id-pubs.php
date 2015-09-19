<?php

require_once 'inesc-id-util.php';

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

function print_publications($authorID, $pub_name, $pub_tbl, $pub_type, $fields, $year, $sectionLevel) {
  $s = "";
  $conn = DB::getInstance();
  $type_str = is_array($pub_type) ? implode(",", $pub_type) : $pub_type;
  $authorSet = is_array($authorID) ? implode(",", $authorID) : $authorID;
  $year_str=($year>0)?" AND p.year=$year ":"";
  $query = "SELECT DISTINCT p.pubid, p.title, p.year,p.month, p.tempdf, p.remarks, rev.*, tp.type
                  FROM Autores a, Pubs p, $pub_tbl rev, TipoPublicacao tp
                  WHERE a.authorid in ($authorSet) AND p.pubid=a.pubid AND p.type in ($type_str) AND
                        rev.pubid=p.pubid AND p.type=tp.typeid AND p.year IS NOT NULL $year_str
                  ORDER BY year desc, p.type asc, month desc, title asc";  // order: PhD, MSc, Grad.
  $pub_result = $conn->query("$query") or die("<b>ERROR ".$errno."</b>: FETCHING $pub_name"); 

  if ($pub_result->rowCount()) {
    $s .= "<h$sectionLevel>$pub_name</h$sectionLevel>";
    $year=0;
    while($row = $pub_result->fetch(PDO::FETCH_ASSOC)){
      if ($row['year'] != $year) {
	$s .= "<h". (1+$sectionLevel) .">".$row['year']."</h".(1+$sectionLevel) .">";
	$year=$row['year'];
      }
      $query="SELECT p.abrvnome FROM Autores a, Pessoal p
                                WHERE a.pubid=" . $row['pubid'] . " AND a.authorid=p.pessoaid
                                ORDER BY autorOrdem";
      /* O programa esta a listar os nomes que se seguem mas nao lista as publicacoes... */
      $people_result = $conn->query("$query") or die("<b>ERROR ".$errno."</b>: FETCHING ROWS");
      $s .= "<ul><li>";
      $str="";

      while($row = $people_result->fetch(PDO::FETCH_ASSOC))
	     $str.=", " . $row['abrvnome'] . ""; // Might be here the problem
      if ($row['tempdf'])
	$title = "<a target=\"_blank\" ".
	  "href=\"server-link-to-files". $row['pubid'] . ".pdf\">".
	  "<b>" . $row['title'] . "</b></a>";
      else
	$title = "<b>" . $row['title'] . "</b>";
      $s .= substr($str,2).", $title,";
      for ($i=0; $i<count($fields); $i++) {
        if (isset($fields[$i])) {
	  if (isset($fields[$i][1]) && strlen($row[$fields[$i][1]])>0) {
	    $s .= " ". $fields[$i][0] .  " ". $row[$fields[$i][1]] .
                  ((isset($fields[$i][2]) && $fields[$i][2] == "NOSEP") ? "" : ',');
          }
	  if (!isset($fields[$i][1]) || strlen($fields[$i][1]) == 0)  $s .= $fields[$i][0];
        }
      }
      $s .= " ".int_to_month($row['month'])." ".$row['year'];
      $s .= "</li></ul>";
    }
  }
  return $s;
}
 

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//
// $sectionLevel is for producing a "<$sectionLevel>Publications</$sectionLevel>"
//  section title. Subsequent sections will behave accordingly.
//
function pubsById($id, $sectionLevel = 2) {
  $errno = 1;
  $year = 0;  //FRANCISCO: not used
  $s = "";

  // INTERNATIONAL PATENTS
  $fields[0]=array("","Number");
  $fields[1]=array("","Location");
  $s0 = print_publications($id, "International Patents", "Patente", 13, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // NATIONAL PATENTS
  $fields[0]=array("Patent number: ","Number");
  $fields[1]=array("","Location");
  $s0 = print_publications($id, "National Patents", "Patente", 17, $fields,  $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // BOOKS
  $fields[0]=array("","Publisher");
  $s0 = print_publications($id, "Books", "Livro", 8, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // EDITED BOOKS
  $fields[0]=array("","Publisher");
  $fields[1]=array("","Series");
  $fields[2]=array("","Number");
  $fields[3]=array("","Location");
  $s0 = print_publications($id, "Edited Books", "LivrosEditorOutros", 9, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // BOOK CHAPTERS
  $fields[0]=array("chapter","Chapter_Title");
  $fields[1]=array("","Publisher");
  $fields[2]=array("","remarks");
  $s0 = print_publications($id, "Book Chapters", "LivroCapitulo", 10, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }
    
  // EDITED JOURNALS
  $fields[0]=array("","Publisher");
  $fields[1]=array("Number","Number");
  $fields[2]=array("Volume","Volume");
  $s0 = print_publications($id, "Edited Journals", "SpecialJournal", 19, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // INTERNATIONAL JOURNALS
  $fields[0]=array("","Journal");
  $fields[1]=array("","Publisher");
  $fields[2]=array("vol.","Volume");
  $fields[3]=array("n.","Number");
  $fields[4]=array("pages","Pages");
  $fields[5]=array("doi: ","DOI");
  $fields[6]=array("","Location");
  $s0 = print_publications($id, "International Journals", "ArtRevista", 1, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // EDITED PROCEEDINGS
  $fields[0]=array("","Publisher");
  $fields[1]=array("","Series");
  $fields[2]=array("","Number");
  $fields[3]=array("","Location");
  $s0 = print_publications($id, "Edited Proceedings", "LivrosEditorOutros", 14, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // INTERNATIONAL CONFERENCES
  $fields[0]=array("<i>In</i>","Conference");
  $fields[1]=array("","Publisher");
  $fields[2]=array("vol.","Volume");
  $fields[3]=array("series","series");
  $fields[4]=array("pages","Pages");
  $fields[5]=array("doi: ","DOI");
  $fields[6]=array("","remarks");
  $fields[7]=array("","Location");
  $s0 = print_publications($id, "International Conferences", "ArtConferencia", 2, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }
     
  // NATIONAL JOURNALS
  $fields[0]=array("","Journal");
  $fields[2]=array("","Publisher");
  $fields[2]=array("vol.","Volume");
  $fields[3]=array("n.","Number");
  $fields[4]=array("pages","Pages");
  $fields[5]=array("","remarks");
  $fields[6]=array("","Location");
  $s0 = print_publications($id, "National Journals", "ArtRevista", 11, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // NATIONAL CONFERENCES
  $fields[0]=array("<i>In</i>","Conference");
  $fields[1]=array("","Publisher");
  $fields[2]=array("vol.","Volume");
  $fields[3]=array("series","series");
  $fields[4]=array("pages","Pages");
  $fields[5]=array("","Location");
  $s0 = print_publications($id, "National Conferences", "ArtConferencia", 3, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }
     
  // TECHNICAL REPORTS
  $fields[0]=array("Tech. Rep.","TRNumber", "NOSEP");
  $fields[1]=array("/","year", "NOSEP");
  $fields[2]=array(" Server, ","");  // just concatenate "Server"
  $s0 = print_publications($id, "Technical Reports", "TechReport", 4, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // PhD THESES
  $fields[0]=array("","type");
  $fields[1]=array("","University");
  $fields[2]=array("","Location");
  $s0 = print_publications($id, "Doctoral Theses", "Dissertacao", 5, $fields, $year, $sectionLevel+1);
  //all theses $s0 = print_publications($id, "Theses", "Dissertacao", array(5,6,7), $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // MSc THESES
  $fields[0]=array("","type");
  $fields[1]=array("","University");
  $fields[2]=array("","Location");
  $s0 = print_publications($id, "Masters Theses", "Dissertacao", 6, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // GRADUATION THESES
  $fields[0]=array("","type");
  $fields[1]=array("","University");
  $fields[2]=array("","Location");
  $s0 = print_publications($id, "Graduation Theses", "Dissertacao", 7, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  // OTHER
  $fields[0]=array("","Publisher");
  $s0 = print_publications($id, "Other Publications", "LivrosEditorOutros", 12, $fields, $year, $sectionLevel+1);
  unset($fields);
  if (trim($s0) != '') { $s .= $s0; }

  if ($sectionLevel == 2) { if (trim($s) != '') $s = "<h$sectionLevel>Publications</h$sectionLevel>" . $s; }
  
  //echo "\$s is $s";
  return $s;
}

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

function pubsByCC($cc) {
  $conn = DB::getInstance();
  $result1 = $conn->query("SELECT pessoaId FROM PessoalInesc P where CC=\"$cc\"");
  $result2 = $conn->query("SELECT pessoaId FROM PessoalEstagiario P where CC=\"$cc\"");

  //while($row = $result1->fetch(PDO::FETCH_ASSOC)) $id.=",".$result1['pessoaId'];

  foreach($result1 as $row) {
    $id .= "," . $row['pessoaId'];
  }

  foreach($result2 as $row) {
    $id .= "," . $row['pessoaId'];
  }

  $id=substr($id,1);
  return pubsById($id, 1);
}


?>
