<?php
use classes\Module;

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

$heroImage = new Module('hero-image');