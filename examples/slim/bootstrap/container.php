<?php

use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Container;

$entries = [];

$entries['notFoundHandler'] = function () {
    return function ($request, \Slim\Http\Response $response) {
        return $response->withStatus(404);
    };
};

$entries['notAllowedHandler'] = function () {
    return function ($request, \Slim\Http\Response $response) {
        return $response->withStatus(405);
    };
};

$entries['errorHandler'] = function (Container $c) {
    return function ($request, \Slim\Http\Response $response, $exception) use ($c) {
        /** @var Exception $exception */
        $c->getAppLogger()->error("Uncaught error: {$exception->getMessage()}", ['exception' => $exception]);

        return $response->withStatus(500);
    };
};

$entries['app.logger'] = function () {
    return new Monolog\Logger('app', [new \Monolog\Handler\RotatingFileHandler(getenv('LOG_APP_DIR') . '/app.log')]);
};

$entries['app.connection'] = function () {
    $config = new Doctrine\DBAL\Configuration();
    $connectionParams = array(
        'dbname' => getenv('DB_APP_NAME'),
        'user' => getenv('DB_APP_USER'),
        'password' => getenv('DB_APP_PASS'),
        'host' => getenv('DB_APP_HOST'),
        'charset' => getenv('DB_APP_CHARSET'),
        'driver' => getenv('DB_APP_DOCTRINE_DRIVER'),
        'unix_socket' => getenv('DB_APP_SOCK') ?: null,
        'port' => getenv('DB_APP_PORT') ?: 3306,
    );

    return Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
};


$entries['app.logger'] = function () {
    return new Monolog\Logger('app', [new \Monolog\Handler\RotatingFileHandler(getenv('LOG_APP_DIR') . '/app.log')]);
};

$entries['domain.response'] = function () {
    return new Damianopetrungaro\CleanArchitecture\UseCase\Response\Response(
        new \Damianopetrungaro\CleanArchitecture\Common\Collection\Collection(),
        new \Damianopetrungaro\CleanArchitecture\Common\Collection\Collection()
    );
};

$entries['domain.users.useCase.listUsers'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\ListUsersUseCase($c->getUserRepository());
};

$entries['domain.users.repository'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\DBALUserRepository($c->getDatabaseConnection());
};

$entries['app.users.request.lisUser'] = function () {
    return new \Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\ListUserRequest();
};


return new Container($entries);