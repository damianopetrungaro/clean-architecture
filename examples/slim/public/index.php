<?php
require __DIR__ . '/../bootstrap/app.php';
$container = require __DIR__ . '/../bootstrap/container.php';

$app = new \Slim\App($container);

$app->run();