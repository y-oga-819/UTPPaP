<?php

declare(strict_types=1);

namespace App\Chapter7;

class UserFactory
{
    public static function create(array $data): User
    {
        if (count($data) < 3) {
            throw new \Exception();
        }

        $id = $data['id'];
        $email = $data['email'];
        $type = $data['user_type'];
        $isEmailConfirmed = $data['is_email_confirmed'];

        return new User($id, $email, $type, $isEmailConfirmed);
    }
}