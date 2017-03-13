<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer;


final class UserTransformer implements UserTransformerInterface
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function mapMultiple(array $users): array
    {
        foreach ($users as $key => $user) {
            $users[$key] = $this->map($user);
        }

        return $users;
    }
}