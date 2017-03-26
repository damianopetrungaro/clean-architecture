<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Transformer;

final class UserTransformer
{
    /**
     * Transform an user array transforming keys and values
     *
     * @param array $user
     *
     * @return array
     */
    public function map(array $user): array
    {
        // Remove password
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'surname' => $user['surname'],
            'email' => $user['email'],
        ];
    }

    /**
     * Transform an array of users array transforming keys and values
     *
     * @param array $users
     *
     * @return array
     */
    public function mapMultiple(array $users): array
    {
        foreach ($users as $key => $user) {
            $users[$key] = $this->map($user);
        }

        return $users;
    }
}