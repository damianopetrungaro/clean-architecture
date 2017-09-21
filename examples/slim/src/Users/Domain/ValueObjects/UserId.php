<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId
{
    /**
     * @var UuidInterface
     */
    private $userId;

    /**
     * UserId constructor.
     *
     * @param UuidInterface $userId
     */
    public function __construct(UuidInterface $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Return a new Uuid from a string
     *
     * @param $userId
     *
     * @return UserId
     */
    public static function createFromString($userId): UserId
    {
        return new self(Uuid::fromString($userId));
    }

    /**
     * Return the password from the value object
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->userId->toString();
    }
}