<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer;


interface UserTransformerInterface
{
    /**
     * Transform an user array transforming keys and values
     *
     * @param array $user
     *
     * @return array
     */
    public function map(array $user): array;

    /**
     * Transform an array of users array transforming keys and values
     *
     * @param array $users
     *
     * @return array
     */
    public function mapMultiple(array $users): array;
}