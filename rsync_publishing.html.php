<?php

// languages
$strings = array('de'=>array(),
                 'en'=>array()
                );

$strings['en'] = array('text_intro'   =>'Publish changes from staging server to the public site.',
                       'text_script'  =>'result of the script:',
                       'butt_preview' =>'preview changes',
                       'butt_showsite'=>'show public site',
                       'butt_publish' =>'publish changes',
                       'butt_ok'      =>'OK',
                      );
$strings['de'] = array('text_intro'   =>'Hier können Sie die Änderungen vom Staging-Server auf die öffentliche Webseite überspielen.',
                       'text_script'  =>'Hier die Ausgabe des Scripts:',
                       'butt_preview' =>'Änderungen anzeigen',
                       'butt_showsite'=>'öffentliche Seite anzeigen',
                       'butt_publish' =>'Änderungen veröffentlichen',
                       'butt_ok'      =>'OK',
                      );

// script
$rsync_script = '';
$stagingcontent_path = kirby()->roots()->content();
$stagingcontent_path .= '/';
$productioncontent_path = $stagingcontent_path . '../../';
$productioncontent_path .= c::get('rsync_publishing.publicsite_folder');
$productioncontent_path .= '/content/';

$rsync_options = c::get('rsync_publishing.rsync_options', '-rlptz -u -v --delete');

if ($get_param !== null) {
  switch ($get_param) {
    case "run":
      $rsync_script = 'rsync ' . $rsync_options;
      $rsync_script .= ' '.$stagingcontent_path;
      $rsync_script .= ' '.$productioncontent_path;
      $output = shell_exec($rsync_script);
      break;
      
    case "test":
      $rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
      $rsync_script .= ' '.$stagingcontent_path;
      $rsync_script .= ' '.$productioncontent_path;
      $output = shell_exec($rsync_script);
      break;

    default :
      $output = "something went wrong!!!";
      break;
  }
} else {
  $rsync_script = 'rsync ' . $rsync_options . ' --dry-run';
  $rsync_script .= ' '.$stagingcontent_path;
  $rsync_script .= ' '.$productioncontent_path;
}

?>

<style>
#rsync_publishing-widget > pre {
  font-family: monospace;
  background: #efefef;
  padding: 1em;
  margin: 1em 0px 1em;
  white-space: pre-wrap;
}
#rsync_publishing-widget p {
  line-height: 1.5em;
} 
</style>

<?php if ($get_param == null) : ?>

<p><?php echo $strings[$lang]['text_intro'] ?></p>

<pre><?php echo $rsync_script ?></pre>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel?widget_rsyncpublishing=test">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-exchange"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_preview'] ?></figcaption>
    </figure>
  </a>
</div>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo c::get('rsync_publishing.site') ?>" target="_blank">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-globe"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_showsite'] ?></figcaption>
    </figure>
  </a>
</div>

<?php else : ?>

<p><?php echo $strings[$lang]['text_script'] ?></p>
<pre><?php echo $output ?></pre>

<?php if ($get_param == 'test') : ?>

<div class="dashboard-box">
  <a class="dashboard-item" href="<?php echo panel()->site()->url() ?>/panel?widget_rsyncpublishing=run">
    <figure>
      <span class="dashboard-item-icon dashboard-item-icon-with-border"><i class="fa fa-exchange"></i></span>
      <figcaption class="dashboard-item-text"><?php echo $strings[$lang]['butt_publish'] ?></figcaption>
    </figure>
  </a>
</div>

<?php elseif ($get_param == 'run') : ?>

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
