<?php

use Damianopetrungaro\CleanArchitectureSlim\Common\Container;

$entries = [];

##########################################################################
##########################################################################
##########################################################################
# Slim Default
##########################################################################
##########################################################################
##########################################################################
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
        $c->getLogger()->error("Uncaught error: {$exception->getMessage()}", [$exception]);

        return $response->withStatus(500);
    };
};

$entries['phpErrorHandler'] = function (Container $c) {
    return function ($request, \Slim\Http\Response $response, $exception) use ($c) {
        /** @var Exception $exception */
        $c->getLogger()->error("Uncaught error: {$exception->getMessage()}", [$exception]);

        return $response->withStatus(500);
    };
};

##########################################################################
##########################################################################
##########################################################################
# App common
##########################################################################
##########################################################################
##########################################################################
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
        'unix_socket' => getenv('DB_APP_SOCKET') ?: null,
        'port' => getenv('DB_APP_PORT') ?: 3306,
    );

    return Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
};

$entries['app.logger'] = function () {
    return new Monolog\Logger('app', [new \Monolog\Handler\RotatingFileHandler(getenv('LOG_APP_DIR') . '/app.log')]);
};

$entries['app.response.slim'] = function () {
    return new \Damianopetrungaro\CleanArchitectureSlim\Common\Response\SlimResponseBuilder;
};

##########################################################################
##########################################################################
##########################################################################
# Domain common
##########################################################################
##########################################################################
##########################################################################
$entries['domain.response'] = function () {
    return new Damianopetrungaro\CleanArchitecture\UseCase\Response\Response(
        new \Damianopetrungaro\CleanArchitecture\Common\Collection\Collection(),
        new \Damianopetrungaro\CleanArchitecture\Common\Collection\Collection()
    );
};

##########################################################################
##########################################################################
##########################################################################
# User
##########################################################################
##########################################################################
##########################################################################

########
# Application
########
$entries['app.users.transformer'] = function () {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Transformer\UserTransformer();
};

$entries['app.users.mapper'] = function () {
    return new Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapper(
        \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Mapper\ZendHydratorFactory::build()
    );
};

########
# Domain
########
$entries['domain.users.useCase.listUsers'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\ListUsersUseCase(
        $c->getUserRepository(),
        $c->getUserMapper()
    );
};

$entries['domain.users.useCase.getUsers'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\GetUserUseCase(
        $c->getUserRepository(),
        $c->getUserMapper()
    );
};

$entries['domain.users.useCase.addUser'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\AddUserUseCase(
        $c->getUserRepository(),
        $c->getUserMapper()
    );
};

$entries['domain.users.useCase.deleteUser'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\DeleteUserUseCase(
        $c->getUserRepository(),
        $c->getUserMapper()
    );
};

$entries['domain.users.useCase.updateUser'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\UpdateUserUseCase(
        $c->getUserRepository(),
        $c->getUserMapper()
    );
};

$entries['domain.users.repository'] = function (Container $c) {
    return new \Damianopetrungaro\CleanArchitectureSlim\Users\Application\Repository\DBALUserRepository(
        $c->getDatabaseConnection(),
        $c->getUserMapper(),
        getenv('DB_TABLE_PREFIX') . 'users' . getenv('DB_TABLE_SUFFIX')
    );
};

return new Container($entries);