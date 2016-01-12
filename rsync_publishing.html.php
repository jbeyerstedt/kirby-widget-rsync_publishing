<?php
// -------------------------------------------
// kirby widget rsync_publishing
//
// copyright: Jannik Beyerstedt | http://jannikbeyerstedt.de | code@jannikbeyerstedt.de
// license: http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 License
// -------------------------------------------


// languages
$strings = array('de'=>array(),
                 'en'=>array()
                );

$strings['en'] = array('text_intro'       => 'Publish changes from staging server to the public site.',
                       'text_script'      => 'result of the script:',
                       'butt_preview'     => 'preview changes',
                       'butt_showsite'    => 'show public site',
                       'butt_publish'     => 'publish changes',
                       'butt_ok'          => 'OK',
                       'butt_abort'       => 'abort',
                       'text_secondary'   => 'publish to secondary site:',
                       'butt_preview_sec' => 'preview changes to secondary',
                       'butt_showsite_sec'=> 'show secondary site',
                      );
$strings['de'] = array('text_intro'       => 'Hier können Sie die Änderungen vom Staging-Server auf die öffentliche Webseite überspielen.',
                       'text_script'      => 'Hier die Ausgabe des Scripts:',
                       'butt_preview'     => 'Änderungen anzeigen',
                       'butt_showsite'    => 'öffentliche Seite anzeigen',
                       'butt_publish'     => 'Änderungen anwenden',
                       'butt_ok'          => 'OK',
                       'butt_abort'       => 'abbrechen',
                       'text_secondary'   => 'Änderungen zur sekundären Seite kopieren:',
                       'butt_preview_sec' => 'Änderungen anzeigen (sekundäre Seite)',
                       'butt_showsite_sec'=> 'sekundäre Seite anzeigen',
                      );

// script
$rsync_script = '';
$stagingContent_path = kirby()->roots()->content() . '/';
$productionContent_path = $stagingContent_path . '../../';
$productionContent_path .= c::get('rsync_publishing.publicSite_folder');
$productionContent_path .= '/content/';
$secondaryContent_path =  $stagingContent_path . '../../';
$secondaryContent_path .= c::get('rsync_publishing.secondarySite_folder');
$secondaryContent_path .= '/content/';

$secondary_enable = c::get('rsync_publishing.secondarySite_enable', false);

$rsync_options = c::get('rsync_publishing.rsyncOptions', '-rlptz -u -v --delete');

if ($get_param !== null) {
  switch ($get_param) {
    case "run":
      $rsync_script = 'rsync ' . $rsync_options;
      $rsync_script .= ' '.$stagingContent_path;
      $rsync_script .= ' '.$productionContent_path;
      $output = shell_exec($rsync_script);
      break;
      
    case "test":
      $rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
      $rsync_script .= ' '.$stagingContent_path;
      $rsync_script .= ' '.$productionContent_path;
      $output = shell_exec($rsync_script);
      break;
      
    case "secondary_run":
      $rsync_script = 'rsync ' . $rsync_options;
      $rsync_script .= ' '.$stagingContent_path;
      $rsync_script .= ' '.$secondaryContent_path;
      $output = shell_exec($rsync_script);
      break;
      
    case "secondary_test":
      $rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
      $rsync_script .= ' '.$stagingContent_path;
      $rsync_script .= ' '.$secondaryContent_path;
      $output = shell_exec($rsync_script);
      break;
      

    default :
      $output = "something went wrong!!!";
      break;
  }
} else {
  $rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
  $rsync_script .= ' '.$stagingContent_path;
  $rsync_script .= ' '.$productionContent_path;
  
  if ($secondary_enable == true) {
    $secondary_rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
    $secondary_rsync_script .= ' '.$stagingContent_path;
    $secondary_rsync_script .= ' '.$secondaryContent_path;
  }
}

?>


<style>
#rsync_publishing-widget > div.code {
  font-family: monospace;
  background: #efefef;
  padding: 1em;
  margin: 1em 0px 1em;
  white-space: pre;

  max-height: 400px;
  overflow-y: scroll;
  overflow-x: auto;
}
#rsync_publishing-widget p {
  line-height: 1.5em;
}
p.secondary {
  margin-top: 20px;
}
</style>


<?php if ($get_param == null) : ?>


<p><?php echo $strings[$lang]['text_intro'] ?></p>

<div class="code"><?php echo $rsync_script ?></div>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel?widget_rsyncpublishing=test">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-exchange"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_preview'] ?></figcaption>
    </figure>
  </a>
</div>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo c::get('rsync_publishing.publicSite_url') ?>" target="_blank">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-globe"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_showsite'] ?></figcaption>
    </figure>
  </a>
</div>

<?php if ($secondary_enable == true) : ?>
<p class="secondary"><?php echo $strings[$lang]['text_secondary'] ?></p>
<div class="code"><?php echo $secondary_rsync_script ?></div>
<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel?widget_rsyncpublishing=secondary_test">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-exchange"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_preview_sec'] ?></figcaption>
    </figure>
  </a>
</div>
<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo c::get('rsync_publishing.secondarySite_url') ?>" target="_blank">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-globe"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_showsite_sec'] ?></figcaption>
    </figure>
  </a>
</div>
<?php endif; ?>


<?php else : ?>


<p><?php echo $strings[$lang]['text_script'] ?></p>
<div class="code"><?php echo $output ?></div>

<?php if ($get_param == 'test' || $get_param == 'secondary_test') : ?>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel?widget_rsyncpublishing=run">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-exchange"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_publish'] ?></figcaption>
    </figure>
  </a>
</div>
<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel/">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-backward"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_abort'] ?></figcaption>
    </figure>
  </a>
</div>

<?php elseif ($get_param == 'run' || $get_param == 'secondary_run') : ?>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel/">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-check"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_ok'] ?></figcaption>
    </figure>
  </a>
</div>

<?php endif; ?>


<?php endif; ?>
