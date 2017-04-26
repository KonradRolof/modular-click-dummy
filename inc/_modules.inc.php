<?php
use classes\Module;
use classes\ModuleAutoLoader;

$autoLoader = new ModuleAutoLoader();
$test = $autoLoader->getModulesFromFiles();
echo '<pre>';
var_dump($test);
echo '</pre>';

// main site navigation
$navigation = new Module('navigation');
$navigation->setVars(
    array(
        'active' => 1
    )
);

// main site header includes $navigation
$header = new Module('header');
$header->setVars(
    array(
        'navigation' => $navigation,
        'active' => 1
    )
);

// main site footer
$footer = new Module('footer');