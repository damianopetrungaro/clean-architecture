<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects;

use Ramsey\Uuid\UuidInterface;

final class UserId
{
    /**
     * @var UuidInterface
     */
    private $userId;

    /**
     * UserId constructor.
     * @param UuidInterface $userId
     */
    public function __construct(UuidInterface $userId)
    {
        $this->userId = $userId;
    }
}