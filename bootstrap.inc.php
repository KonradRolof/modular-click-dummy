<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_DIR', __DIR__);
// load class Module
require_once BASE_DIR . '/classes/Module.php';

// load modules
require BASE_DIR . '/inc/modules.inc.php';