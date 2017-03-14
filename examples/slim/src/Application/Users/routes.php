<?php

/** @var \Slim\App $app */
$app->get('/users', \Damianopetrungaro\CleanArchitectureSlim\Application\Users\Controller\ListUsersController::class);
$app->get('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Application\Users\Controller\GetUserController::class);
