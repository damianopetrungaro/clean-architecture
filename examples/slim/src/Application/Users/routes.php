<?php

/** @var \Slim\App $app */
$app->get('/users', \Damianopetrungaro\CleanArchitectureSlim\Application\Users\Controller\ListUsersController::class);
