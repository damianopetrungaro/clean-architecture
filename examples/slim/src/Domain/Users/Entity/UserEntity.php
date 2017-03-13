<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity;

use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Surname;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\UserId;

final class UserEntity
{
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var Name
     */
    private $name;
    /**
     * @var Surname
     */
    private $surname;
    /**
     * @var Email
     */
    private $email;
    /**
     * @var Password
     */
    private $password;

    /**
     * UserEntity constructor.
     * @param UserId $userId
     * @param Name $name
     * @param Surname $surname
     * @param Email $email
     * @param Password $password
     */
    public function __construct(UserId $userId, Name $name, Surname $surname, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }
}