<?php
// -------------------------------------------
// kirby widget rsync_publishing
//
// copyright: Jannik Beyerstedt | http://jannikbeyerstedt.de | code@jannikbeyerstedt.de
// license: http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 License
// -------------------------------------------


// languages
$lang = panel()->user()->language();

switch ($lang) {
  case 'en':
    $lang_title = 'Publishing';
    break;
  case 'de':
    $lang_title = 'Veröffentlichung';
    break;
  default:
    $lang_title = 'language not supported';
}

if(panel()->user()->role() == 'admin') {
  return array(
    'title' => $lang_title,
    'html' => function() {
      return tpl::load(__DIR__ . DS . 'rsync_publishing.html.php', array(
        'get_param' => get('widget_rsyncpublishing'),
        'lang' => panel()->user()->language(),
      ));
    }
  );
} else {
  return false;
}
