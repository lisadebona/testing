<?php
require_once("../globals.php");
require_once("$srcdir/options.inc.php");
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Common\Logging\EventAuditLogger;
use OpenEMR\Core\Header;
use OpenEMR\OeUI\OemrUI;

function parentPageTitle() {
  return "Education and Resources";
}

function slugify($text, $divider='-'){
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, $divider);
  $text = preg_replace('~-+~', $divider, $text);
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}


function getBodyContent($filename) {
  $d = new DOMDocument;
  $mock = new DOMDocument;
  $d->loadHTML(file_get_contents($filename));
  $body = $d->getElementsByTagName('body')->item(0);
  foreach ($body->childNodes as $child){
      $mock->appendChild($mock->importNode($child, true));
  }

  return $mock->saveHTML();
}