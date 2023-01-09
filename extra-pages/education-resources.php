<?php
/*
 * Date Created: 01.08.2023
 */

require_once("../globals.php");
require_once("$srcdir/options.inc.php");
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Common\Logging\EventAuditLogger;
use OpenEMR\Core\Header;
use OpenEMR\OeUI\OemrUI;
require_once(dirname(__FILE__).'/settings.php');

$is_home_page = ( isset($_GET['file']) && $_GET['file'] ) ? false : true;

$PARENT_TITLE = parentPageTitle();


$content_json = @file_get_contents('./data.json');
$links = ($content_json) ? @json_decode($content_json) : '';
$single_content = '';
$single_page_title = '';
$customStyles = '';
if( isset($_GET['file']) && $_GET['file'] ) {
  $current = $_GET['file'];
  foreach ($links as $e) {
    $pageFile = $e->file;
    if($pageFile==$current) {
      $single_page_title = $e->title;
      $single_content = getBodyContent('./content/' . $pageFile);
      $content = @file_get_contents('./content/' . $pageFile);
      $styles = explode('<style type="text/css">',$content);
      if($styles) {
        $customStyles = str_replace('</style>','',$styles[1]);
      }
    }
  }
}

?>
<html>
  <head>
    <title><?php echo xlt($PARENT_TITLE); ?></title>
    <?php Header::setupHeader(['datetime-picker', 'jquery-ui', 'jquery-ui-redmond', 'opener', 'moment']); ?>
    
    <?php if ($single_content && $customStyles) { ?>
    <style type="text/css"><?php echo $customStyles ?></style> 
    <?php } ?>
    <link rel="stylesheet" href="./css/styles.css">
  </head>
  <body>

    <main id="content" data-parent="<?php echo xlt($PARENT_TITLE); ?>">
      <div class="wrapper">

        <?php if ( $is_home_page ) { ?>

          <div class="home">
            <h1 class="page-title"><?php echo $PARENT_TITLE ?></h1>
            <div id="mainpage">
              <?php  
              
              
              if($links) { ?>
                <ul id="educationLinks" class="links three-columns">
                  <?php foreach ($links as $e) {
                    $pagetitle = $e->title; 
                    $pagelink = ($e->url) ? $e->url : 'javascript:void(0)';
                    $file = $e->file;
                    if($file) {
                      $pagelink = '?file=' . $file;
                    }
                    ?>
                    <li><a href="<?php echo $pagelink ?>"><?php echo $pagetitle ?></a></li> 
                  <?php } ?>
                </ul>
              <?php } ?>
            </div>
          </div>

        <?php } else { ?>

          <div class="single single-page">
            
            <?php if ($single_content) { ?>
              
              <div class="breadcrumb">
                <a href="./education-resources.php"><?php echo $PARENT_TITLE ?></a>
                <span class="sep">/</span>
                <span class="current"><?php echo $single_page_title ?></span>
              </div>

              <h1 class="page-title"><?php echo $single_page_title ?></h1>

              <div class="entry">
                <?php echo $single_content ?>
              </div>

            <?php } else { ?>
              <h1>Page Not Found!</h1>
            <?php } ?>

          </div>

        <?php } ?>

      </div>
    </main>


    <script src="./js/scripts.js"></script>
  </body>
</html>

