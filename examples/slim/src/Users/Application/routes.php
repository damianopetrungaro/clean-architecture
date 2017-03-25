<?php

/** @var \Slim\App $app */
$app->get('/users', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\ListUsersController::class);
$app->post('/users', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\AddUserController::class);
$app->get('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\GetUserController::class);
$app->put('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\UpdateUserController::class);
