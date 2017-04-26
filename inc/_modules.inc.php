<?php
use classes\ModuleAutoLoader;

$autoLoader = new ModuleAutoLoader();
$modules = $autoLoader->getModulesFromFiles();

// get variable from array keys
foreach ($modules as $key => $module) {
    $$key = $module;
}

// main site navigation
$navigation->setVars(
    array(
        'active' => 1
    )
);

// main site header includes $navigation
$header->setVars(
    array(
        'navigation' => $navigation,
        'active' => 1
    )
);