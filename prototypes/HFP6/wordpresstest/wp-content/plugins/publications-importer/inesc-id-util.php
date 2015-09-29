<?php

require_once "inesc-id-config.php";

function nameById($id) {
  $conn = DB::getInstance();
  $result = $conn->query("SELECT nome FROM PessoalInesc WHERE pessoaId=\"" . trim($id) . "\"");
  if (!$result)
    $result = $conn->query("SELECT nome FROM PessoalEstagiario WHERE pessoaId=\"" . trim($id) . "\"");
  $s = "";
  
  while($row = $result->fetch(PDO::FETCH_ASSOC)) { $s .= $row['nome']; }

  /*
  foreach($result as $row) {
    $s .= $row['nome'];
  }
  */

  return $s;
}

// returns field 'instituicao' (a summary of the institution's description)
function instituteById($id) {
  $conn = DB::getInstance();
  $rs = $conn->query("SELECT * FROM Instituicoes WHERE instituicaoId=\"" . trim($id) . "\"");
  $s = "";
  while($row = $rs->fetch(PDO::FETCH_ASSOC)) { $s .= $row['nome']; }
  //if(odbc_fetch_row($rs)) { $s .= odbc_result($rs, 'nome'); }

  /*
  foreach($rs as $row) {
    $s .= $row['nome'];
  }
  */

  return $s;
}

function authorIdByNumber($ids) {
  $pids = array();
  foreach ($ids as $id) {
    $conn = DB::getInstance();
    $result1 = $conn->query("SELECT pessoaId FROM PessoalInesc WHERE numero=\"$id\"");
    $row = $result1->fetchAll();
    if ($result1) {
      if ($result1->rowCount())
        $pids[] = $row['pessoaId'];
    }
    $result2 = $conn->query("SELECT pessoaId FROM PessoalEstagiario WHERE numero=\"$id\"");
    $row = $result2->fetchAll();
    if ($result2) {
      if ($result2->rowCount())
        $pids[] = $row['pessoaId'];
    }
  }
  return $pids;
}

function int_to_month($month) {
  switch ($month) {
  case 1: $ret="January"; break;
  case 2: $ret="February"; break;
  case 3: $ret="March"; break;
  case 4: $ret="April"; break;
  case 5: $ret="May"; break;
  case 6: $ret="June"; break;
  case 7: $ret="July"; break;
  case 8: $ret="August"; break;
  case 9: $ret="September"; break;
  case 10: $ret="October"; break;
  case 11: $ret="November"; break;
  case 12: $ret="December"; break;
  default: $ret=""; break;
  }
  return $ret;
}

?>
