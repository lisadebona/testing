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
      $content = getBodyContent('./content/' . $pageFile);
      $fullContent = @file_get_contents('./content/' . $pageFile);

      //CLEAN UP CSS
      $styles = explode('<style type="text/css">',$fullContent);
      if($styles) {
        if( isset($styles[1]) && $styles[1] ) {
          $strs = str_replace('</style>','',$styles[1]);
          if( $strs = explode(';',$styles[1]) ) {
            $cssData = '';
            $dataStrs = explode('</style>',$styles[1]);
            if( isset($dataStrs[0]) && $dataStrs[0] ) {
              $htmldata = $dataStrs[0];
              $customStyles = preg_replace('/\s*@import.*;\s*/iU', '', $htmldata);
            }
          }
        }
      }

      $page_content = explode('<body.*',$content);
      $page_html_data = ( isset($page_content[0]) && $page_content[0] ) ? str_replace('https://www.google.com/url?q=','',$page_content[0]) : '';
      $single_content = $page_html_data;
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
    <script src="./js/scripts.js"></script>
  </head>
  <body>

    <main id="content" data-parent="<?php echo xlt($PARENT_TITLE); ?>">
      <div class="wrapper">

        <?php if ( $is_home_page ) { ?>

          <div class="home">
            <div class="titlediv">
              <h1 class="page-title"><?php echo $PARENT_TITLE ?></h1>
              <?php if( acl_check('admin', 'super', $_SESSION['authUser']) ) { ?>
                <a href="javascript:void(0)" class="settings-button" aria-label="Settings"><i class="fa fa-cog" aria-hidden="true"></i></a>
              <?php } ?>
            </div>
            
            <div id="mainpage">
              <?php if($links) { ?>
                <ul id="educationLinks" class="links three-columns">
                  <?php foreach ($links as $e) {
                    $pagetitle = $e->title; 
                    $pagelink = ($e->url) ? $e->url : 'javascript:void(0)';
                    $file = $e->file;
                    $target = ($e->url) ? 'target="_blank"':'';
                    $link_class = ($e->url) ? 'external-link':'internal-link';
                    if($file) {
                      $pagelink = '?file=' . $file;
                    } ?>
                    <li data-file="<?php echo $e->title ?>" data-url="<?php echo $e->url ?>"><a href="<?php echo $pagelink ?>"<?php echo $target ?> class="<?php echo $link_class ?>"><?php echo $pagetitle ?></a></li> 
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


    
  </body>
</html>

