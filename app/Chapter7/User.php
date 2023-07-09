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

    public function changeEmail(string $newEmail, string $companyDomainName, int $numberOfEmployees): int
    {
        if ($this->email === $newEmail) {
            return $numberOfEmployees;
        }

        $emailDomain = explode('@', $newEmail)[1];
        $isEmailCorporate = $emailDomain == $companyDomainName;
        $newType = $isEmailCorporate ? UserType::Employee : UserType::Customer;

        if (!$this->type->equals($newType)) {
            $delta =  $newType == UserType::Employee ? 1 : -1;
            $newNumber = $numberOfEmployees + $delta;
            $numberOfEmployees = $newNumber;
        }

        $this->email = $newEmail;
        $this->type = $newType;

        return $numberOfEmployees;
    }
}