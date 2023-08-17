<?php

/**
 * @file
 * The bootstrapping file where required files are added and required
 * variables instantiated.
 */


// The BASE_PATH is where the framework files live.
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT'] . '/../_knot/');

// The supportive functions for knot.
require BASE_PATH . 'tags.php';

// For debugging purposes only. When not using Docksal, the local host name
// can be added here.
if (str_contains($_SERVER['HTTP_HOST'], 'docksal.site')) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL | E_STRICT);
  require BASE_PATH . 'debugger.php';
}

// Autoload classes
require __DIR__ . '/../vendor/autoload.php';

// The application will have specific code requirements that extend the
// knot framework. Include the "bootstrap" file for the application here.
//require BASE_PATH . '_tbr/tbr.php';
