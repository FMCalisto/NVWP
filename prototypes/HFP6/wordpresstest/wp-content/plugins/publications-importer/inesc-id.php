<?php
ini_set('display_startup_errors',1); 
ini_set('display_errors',1); 
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once 'inesc-id-util.php';
require_once 'inesc-id-people.php';
require_once 'inesc-id-pubs.php';
require_once 'inesc-id-advising.php';
require_once 'inesc-id-config.php';


# the function registered by the extension gets the text between the
# tags as input and can transform it into arbitrary HTML code.
# Note: The output is not interpreted as WikiText but directly
#       included in the HTML output. So Wiki markup is not supported.
# To activate the extension, include it from your LocalSettings.php
# with: include("extensions/YourExtensionName.php");

$wgExtensionFunctions[] = "wfExampleExtension";

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//
//  Register the extension with the WikiText parser.
//  The first parameter is the name of the new tag. In this case it defines
//  the tag:
//        <inesc-id> ... </inesc-id>
//        [inces-id] ... [/inesc-id] <== WordPress
//  The second parameter is the callback function for processing the text
//  between the tags.
//
function wfExampleExtension() {
  global $wgParser;  // MediaWiki global variable
  $wgParser->setHook("inesc-id", "renderINESCID");
}

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//
//  The callback function for converting the input text to HTML output.
//  The function registered by the extension gets the text between the
//  tags as $input and transforms it into arbitrary HTML code.
//  Note: the output is not interpreted as WikiText but directly included in
//  the HTML output. So Wiki markup is not supported.
//
//  To activate the extension, include it from your LocalSettings.php
//  with: include("extensions/YourExtensionName.php");
//
//  $argv is an array containing any arguments passed to the extension like:
//     <inesc-id what="foo" bar>..
//
//  According to the metawiki, this works in MediaWiki 1.5.5.
//   <inesc-id what="person" id="62">This text is not actually used</inesc-id>
//
// Personal information:
//    <inesc-id what='person' id='62'></inesc-id>
//
// Information for a group:
//    <inesc-id what='publications' cc='IP02'></inesc-id>
//

function renderINESCID($input, $argv) {
  // connect to the database
  $html = "";
  if ($argv['what'] == 'person') {
    $id = split(",", trim($argv["id"]));
    if ($id != '') {
      // information about someone:
      //  1. personal contacts and summary
      //  2. publications by person
      //  3. advisory work by person
      //
      $html .= personById($id[0]);

      $internalIds = authorIdByNumber($id);  // use all Ids
      $html .= pubsById($internalIds);
      $html .= advisingById($internalIds);
    }
    
  }
  else if ($argv['what'] == 'advising') {
    $id = split(",", trim($argv["id"]));
    if ($id != '') {
      $internalIds = authorIdByNumber($id);  // use all Ids
      $html .= iconv('latin1', 'UTF-8', advisingById($internalIds));
    }

  }
  else if ($argv['what'] == 'publications') {
    // information about some "centro de custo":
    //  1. currently, only a list of publications
    //
    $cc = trim($argv["cc"]);
    $id = trim($argv["id"]);
    if ($cc != '') {
      $html .= iconv('latin1', 'UTF-8', pubsByCC($cc));
    }
    else if ($id != '') {
      $html .= iconv('latin1', 'UTF-8', pubsById(authorIdByNumber( array($id))));
    }
  }
  /*else if ($argv['what'] == 'publications') {
    // information about some "centro de custo":
    //  1. currently, only a list of publications
    //
    $cc = trim($argv["cc"]);
    if ($cc != '') {
      $html .= pubsByCC($idDBLink, $cc);
    }
  }*/
  else if ($argv['what'] == 'calls') {
    // information about some "centro de custo":
    //  1. currently, only a list of publications
    //
    $cc = trim($argv["cc"]);
    $showClosed = isset($argv['showclosed']) ? trim($argv['showclosed']) : "";
    if ($cc != '') {
      $html .= iconv('latin1', 'UTF-8', callsByCC($cc, $showClosed == "yes"));
    }
  }
  else {
    // oops! no text...
  }


  return $html;
}

?>
