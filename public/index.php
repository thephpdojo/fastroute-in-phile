<?php
require __DIR__ . "/../vendor/autoload.php";

$helpers = [
    'allroutepatterns',
    'layout',
    'request',
    'response',
    'bootstrap' //finaly, load the bootstrap helper
];

foreach($helpers as $helper) {
    require __DIR__ . "/../helper/$helper.php";
}

bootstrap();
