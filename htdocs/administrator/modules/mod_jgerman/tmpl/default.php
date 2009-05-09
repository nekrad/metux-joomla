<?php
/**
 * $Id: default.php 466 2009-03-27 21:52:38Z sisko1990 $
 * Author: Jan Erik Zassenhaus (Jan.Zassenhaus@jgerman.de)
 * BugFix: Uwe Walter (admin@joomlakom.de)
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
$check  = new Check();
$server	= $check->getAvailable();
?>

<?php
  if($params->get( 'auto_check' ) == 'auto_check_no' && !$_POST['check1'] && !$_POST['check2']) {
?>
  <div style="text-align: center;">
    <h3>Möchten Sie eine Überprüfung auf neue Versionen vornehmen?</h3>
    <br />
    <form method="post" action="<?php echo $PHP_SELF; ?>">
      <input type="submit" name="check1" value="Ja, Überprüfung starten" />
    </form>
  </div>

<?php
  } elseif($server == 'impossible' && !$_POST['check2']) {
?>
  <div style="text-align: center;">
    <span style="color: red;"><b>&bdquo;fsockopen&rdquo; oder &bdquo;curl&rdquo; sind auf Ihrem Server deaktiviert!
    <br />
    Es konnte kein Onlinestatus ermittelt werden!</b>
    <br />
    Aus Sicherheitsgründen wurde die Überprüfung auf eine neue Version abgebrochen, da es zum Einfrieren des
    Joomla!-Backends führen kann, wenn J!German nicht erreichbar sein sollte.
    Sie können diese Überprüfung aber trotzdem durchführen.
    <br />
    Klicken Sie einfach auf &bdquo;Trotzdem überprüfen&rdquo;.</span>
    <br />
    <br />
    <form method="post" action="<?php echo $PHP_SELF; ?>">
      <input type="submit" name="check2" value="Trotzdem überprüfen" />
    </form>
  </div>
<?php
  } else {
?>
    <div style="text-align: center;">
      <strong><b>Die installierte deutsche Übersetzung für das</b></strong>
    </div>
    <table class="adminlist">
      <tr>
        <td class="title">
          <div style="text-align: center;">
            <strong>Frontend ist:</strong>
        	</div>
        </td>
        <td class="title">
          <div style="text-align: center;">
            <strong>Backend ist:</strong>
        	</div>
        </td>
      </tr>
      <tr>
        <td>
          <?php
            if($check->getVersion('frontend') != 'missing' && $server != 'offline' && $server != 'not responding') {
          ?>
            <img src="http://versioncheck.jgerman.de/lang/<?php echo $check->getVersion('frontend'); ?>/<?php echo $imagesize ?>" alt="Frontend" style="display: block; margin: 0px auto;" />
          <?php
            } elseif($server == 'offline') {
            ?>
              <div style="text-align: center;">
                Der Server ist offline!
              </div>
          <?php
            } elseif ($server == 'not responding') {
          ?>
              <div style="text-align: center;">
                Der Server anwortet nicht!
              </div>
          <?php
            } else {
          ?>
              <div style="text-align: center;">
                Sprache nicht installiert!
              </div>
          <?php
              }
          ?>
        </td>
        <td>
          <?php
            if($check->getVersion('backend') != 'missing' && $server != 'offline' && $server != 'not responding') {
          ?>
            <img src="http://versioncheck.jgerman.de/lang/<?php echo $check->getVersion('backend'); ?>/<?php echo $imagesize ?>" alt="Backend" style="display: block; margin: 0px auto;" />
          <?php
            } elseif($server == 'offline') {
            ?>
              <div style="text-align: center;">
                Der Server ist offline!
              </div>
          <?php
            } elseif ($server == 'not responding') {
          ?>
              <div style="text-align: center;">
                Der Server anwortet nicht!
              </div>
          <?php
            } else {
          ?>
              <div style="text-align: center;">
                Sprache nicht installiert!
              </div>
          <?php
              }
          ?>
        </td>
      </tr>
      <?php
        if($params->get( 'check_core' ) == 'check_core_show') {
      ?>
        <tr>
          <td colspan="2">
            <div style="text-align: center;">
              <strong>Joomla! 1.5 selbst ist:</strong>
            </div>
            <?php
              if($server != 'offline' && $server != 'not responding') {
            ?>
              <img src="http://versioncheck.jgerman.de/core/<?php echo JVERSION; ?>/<?php echo $imagesize ?>" alt="Joomla!-Core" style="display: block; margin: 0px auto;" />
            <?php
              } elseif ($server == 'not responding') {
            ?>
                <div style="text-align: center;">
                  Der Server antwortet nicht!
                </div>
            <?php
              } else {
            ?>
                <div style="text-align: center;">
                  Der Server ist offline!
                </div>
            <?php
              }
            ?>
          </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
      if($params->get( 'notice' ) == 'notice_show') {
    ?>
      Um diese Anzeige zu entfernen, löschen Sie einfach das &bdquo;Update nötig?&rdquo;-Modul unter &bdquo;Erweiterungen&rdquo; &rarr; &bdquo;Module&rdquo; &rarr; &bdquo;Administrator&rdquo;.
    <?php
      }
    }
  ?>
  <hr />
  <div style="text-align: center;">
    <strong>Ein Service von <a href="http://www.jgerman.de" target="_blank">www.jgerman.de</a></strong>
  </div>