<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Mapper;


use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy\EmailStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy\NameStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy\PasswordStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy\SurnameStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy\UserIdStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\Reflection;

class ZendHydratorFactory
{
    public static function build()
    {
        $reflectionHydrator = new Reflection();
        $reflectionHydrator->setNamingStrategy(new MapNamingStrategy([
            'id' => 'userId',
            'name' => 'name',
            'surname' => 'surname',
            'email' => 'email',
            'password' => 'password',
        ]));

        $userIdStrategy = new UserIdStrategy();
        $reflectionHydrator->addStrategy('userId', $userIdStrategy);
        $reflectionHydrator->addStrategy('id', $userIdStrategy);
        $reflectionHydrator->addStrategy('name', new NameStrategy());
        $reflectionHydrator->addStrategy('surname', new SurnameStrategy());
        $reflectionHydrator->addStrategy('email', new EmailStrategy());
        $reflectionHydrator->addStrategy('password', new PasswordStrategy());
        return $reflectionHydrator;
    }
}