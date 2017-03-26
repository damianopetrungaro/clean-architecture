<?php

/** @var \Slim\App $app */
$app->post('/users', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\AddUserController::class);
$app->get('/users', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\ListUsersController::class);
$app->get('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\GetUserController::class);
$app->put('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\UpdateUserController::class);
$app->delete('/users/{id}', \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller\DeleteUserController::class);