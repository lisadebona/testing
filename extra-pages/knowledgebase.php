<?php

/**
 *  Daily Summary Report. (/interface/reports/daily_summary_report.php)
 *
 *  This report shows date wise numbers of the Appointments Scheduled,
 *  New Patients, Visited patients, Total Charges, Total Co-pay and Balance amount for the selected facility & providers wise.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Rishabh Software
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2016 Rishabh Software
 * @copyright Copyright (c) 2017-2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../globals.php");
require_once("$srcdir/options.inc.php");
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Common\Logging\EventAuditLogger;
use OpenEMR\Core\Header;
use OpenEMR\OeUI\OemrUI;
?>
<html>
  <head>
    <title><?php echo xlt('Knowledgebase'); ?></title>
    <?php Header::setupHeader(['datetime-picker', 'jquery-ui', 'jquery-ui-redmond', 'opener', 'moment']); ?>
    <link rel="stylesheet" href="./css/styles.css">
  </head>
  <body>
    <main id="content">
      <div class="wrapper">
        <h1 class="page-title">Knowledgebase</h1>

        <ul class="links three-columns">
          <li><a href="javascript:void(0)">Continuing Education Credit</a></li>
          <li><a href="javascript:void(0)">Policy Manual</a></li>
          <li><a href="javascript:void(0)">Employee Onboarding Sheet </a></li>
          <li><a href="javascript:void(0)">MHER Trainings</a></li>
        </ul>

      </div>
    </main>
  </body>
</html>

