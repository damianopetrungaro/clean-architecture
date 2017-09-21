<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Mapper;


use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy\EmailStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy\NameStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy\PasswordStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy\SurnameStrategy;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy\UserIdStrategy;
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