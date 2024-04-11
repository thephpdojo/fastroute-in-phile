<?php
require __DIR__ . "/../vendor/autoload.php";

function helper(string $helper) {
    require_once __DIR__ . "/../helper/$helper.php";
}

$helpers = [
    'allroutepatterns',
    'layout',
    'request',
    'response',
    'bootstrap' //finaly, load the bootstrap helper
];

foreach($helpers as $helper) {
    helper($helper);
}

bootstrap();
