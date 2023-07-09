<?php

declare(strict_types=1);

namespace App\Chapter7;

class UserFactory
{
    public static function create(array $data)
    {
        if (count($data) < 3) {
            throw new \Exception();
        }

        $id = $data['id'];
        $email = $data['email'];
        $type = $data['user_type'];

        return new User($id, $email, $type);
    }
}