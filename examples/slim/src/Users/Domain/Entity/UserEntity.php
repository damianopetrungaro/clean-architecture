<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity;

use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Surname;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

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