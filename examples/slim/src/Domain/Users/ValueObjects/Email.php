<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects;


final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("$email is not a valid email");
        }
        if (strlen($email) > 255) {
            throw new \InvalidArgumentException("$email must be less than 255 chars");
        }
        $this->email = $email;
    }

    /**
     * Return the email from the value object
     *
     * @return string
     */
    public function getValue()
    {
        return $this->email;
    }
}