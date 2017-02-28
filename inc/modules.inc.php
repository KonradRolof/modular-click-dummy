<?php
$navigation = new Module('navigation');
$navigation->setVars(
    array(
        'active' => 1
    )
);

$header = new Module('header');
$header->setVars(
    array(
        'navigation' => $navigation,
        'active' => 1
    )
);

$footer = new Module('footer');