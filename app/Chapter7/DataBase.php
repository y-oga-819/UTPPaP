<?php

declare(strict_types=1);

namespace App\Chapter7;

class DataBase
{
    private static $users = [
        1 => [
            'email' => 'mail@example.com',
            'user_type' => UserType::Customer,
        ],
    ];

    private static $company = [
        'domain_name' => 'yukineko.work',
        'number_of_employees' => 10,
    ];

    public static function getUserById(int $userId): array
    {
        return static::$users[$userId];
    }

    public static function saveUser(User $user): void
    {
        static::$users[$user->userId] = [
            'email' => $user->email,
            'user_type' => $user->type,
        ];
    }

    public static function getCompany(): array
    {
        return static::$company;
    }

    public static function saveCompany(int $num): void
    {
        static::$company['number_of_employees'] = $num;
    }
}