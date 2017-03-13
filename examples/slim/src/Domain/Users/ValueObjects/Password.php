<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects;


final class Password
{
    /**
     * @var string
     */
    private $password;

    /**
     * Email constructor.
     * @param string $password
     */
    public function __construct(string $password)
    {
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException("Password must be longer than 6 char");
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Create a Password value object from an hashed password
     *
     * @param string $password
     *
     * @return Password
     */
    public static function createFromHashedPassword(string $password): Password
    {
        $self = unserialize(sprintf('O:%u:"%s":0:{}', strlen(self::class), self::class));
        $self->password = $password;

        return $self;
    }

    /**
     * Return true if password is valid, otherwise false
     *
     * @param string $password
     *
     * @return bool
     */
    public function checkValidity(string $password) : bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * Return the password from the value object
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->password;
    }
}