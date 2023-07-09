<?php

declare(strict_types=1);

namespace App\Chapter7;

class User
{
    public function __construct(
        public int $userId,
        public string $email,
        public UserType $type,   
    ) {        
    }

    public function changeEmail(string $newEmail, Company $company): void
    {
        if ($this->email === $newEmail) {
            return;
        }

        $newType = $company->isEmailCorporate($newEmail) ? UserType::Employee : UserType::Customer;

        if (!$this->type->equals($newType)) {
            $delta =  $newType == UserType::Employee ? 1 : -1;
            $company->changeNumberOfEmployees($delta);
        }

        $this->email = $newEmail;
        $this->type = $newType;
    }
}