<?php

declare(strict_types=1);

namespace App\Chapter7;

class DataBase
{
    private static $users = [];

    private static $company = [
        'domain_name' => 'yukineko.work',
        'number_of_employees' => 10,
    ];

    public function getUserById(int $userId): array
    {
        return static::$users[$userId];
    }

    public function saveUser(User $user): void
    {
        static::$users[$user->userId] = [
            'id' => $user->userId,
            'email' => $user->email,
            'user_type' => $user->type,
            'is_email_confirmed' => $user->isEmailConfirmed,
        ];
    }

    public function getCompany(): array
    {
        return static::$company;
    }

    public function saveCompany(Company $company): void
    {
        static::$company['number_of_employees'] = $company->numberOfEmployees;
    }
}