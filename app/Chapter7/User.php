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

    public function changeEmail(int $userId, string $newEmail): void
    {
        $data = DataBase::getUserById($userId);

        $this->userId = $userId;
        $this->email = $data['email'];
        $this->type = $data['user_type'];

        if ($this->email === $newEmail) {
            return;
        }

        $companyData = DataBase::getCompany();
        $companyDomainName = $companyData['domain_name'];
        $numberOfEmployees = $companyData['number_of_employees'];

        $emailDomain = explode('@', $newEmail)[1];
        $isEmailCorporate = $emailDomain == $companyDomainName;
        $newType = $isEmailCorporate ? UserType::Employee : UserType::Customer;

        if (!$this->type->equals($newType)) {
            $delta =  $newType == UserType::Employee ? 1 : -1;
            $newNumber = $numberOfEmployees + $delta;
            DataBase::saveCompany($newNumber);
        }

        $this->email = $newEmail;
        $this->type = $newType;

        DataBase::saveUser($this);
        MessageBus::sendEmailChangedMessage($userId, $newEmail);
    }
}