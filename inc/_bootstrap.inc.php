<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// load class Module
require_once __DIR__ . '/../classes/Module.php';
require_once __DIR__ . '/../classes/ModuleAutoLoader.php';

// load modules
require_once __DIR__ . '/_modules.inc.php';