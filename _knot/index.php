<?php

/**
 * @file
 * The root action file where the process starts.
 */

// A call to the bootstrapping file.
use App\Knot;
use App\Menu;
use App\Page;
use App\Session;

require $_SERVER['DOCUMENT_ROOT'] . '/../_knot/knot.php';

// Setting the root path of the site based on the directory where the
// symlink index file is called from (an /admin path can have a completely
// separate site application).
Knot::set('root_path', dirname($_SERVER['SCRIPT_FILENAME']));
Knot::set('web_path', dirname($_SERVER['SCRIPT_NAME']));

$session = new Session();
Knot::set('session', $session);

// Required config and menu files from the site.
//todo, register items to Knot?
require Knot::get('root_path') . '/_config/config.ssi';
if (file_exists(Knot::get('root_path') . '/_config/config-local.ssi')) {
  require Knot::get('root_path') . '/_config/config-local.ssi';
}
require Knot::get('root_path') . '/_config/menu.ssi';

if ($session->has('username')) {
  Knot::set('_username', $session->get('username'));
}

// What path is called from the user request or URI.
$q = rtrim(($_REQUEST['q'] ?? ''), '/');
Knot::set('response_path', $q);
$__query_path = var_define(Knot::get('default_page'), $q);
// The path to the page content file or FALSE if not found where expected.
$__file_path = get_path($__query_path, Knot::get('content_path'));

// Set the path in the Menu, so it knows how to build the menu correctly.
Menu::$path = $__query_path;
// Set Page to be called by the template files.
Page::$menu = Menu::renderMenu();

if (isset(Menu::$title)) {
  Page::$title = Menu::$title;
}
if (!isset(Page::$template) && isset(Menu::$template)) {
  Page::$template = Menu::$template;
}

if (web_param('logout') == 'true') {
  $session->destroy();
  Knot::set('_username', '');
  echo 'Logged Out';
}

if (Knot::get('restricted') && Menu::$restricted !== FALSE && !Knot::get('_username')) {
  if (web_param('task')) {
    $page = Knot::get('content_path') . '_process/login.ssi';
    Page::$content = page_content($page);
  }
  else {
    Page::$title = 'Log In';
    Page::$content = page_content(get_path('login', Knot::get('content_path')));
  }
}
// If there is something to be processed, do that here.
elseif (isset($route) && $route) {
  $page = Knot::get('content_path') . '_process/' . strtolower($route) . '.ssi';
  Page::$content = page_content($page);
}
// Set all that collected information into Page by grabbing a rendered
// version of the page file.
elseif ($__file_path) {
  Page::$content = page_content($__file_path);
}
// A wrong path was called that isn't accounted for so tell them with an
// error page.
else {
  Page::$title = 'Page Not Found';
  Page::$template = 'error';
  Page::$content = '';
  http_response_code(404);
}

// The rendering begins here.
$rendering = TRUE;
ob_start();
include BASE_PATH . "_templates/base.inc";
if (ob_get_status() && $rendering) {
  $out = ob_get_clean();
  print $out;
}
