<?php

declare(strict_types=1);

namespace App\Chapter7;

class UserController
{
    public function __construct(
        private readonly DataBase $dataBase = new DataBase(),
        private readonly MessageBus $messageBus = new MessageBus(),
    ) {
    }

    public function changeEmail(int $userId, string $newEmail): void
    {
        $data = $this->dataBase->getUserById($userId);
        $email = $data['email'];
        $type = $data['user_type'];
        $user = new User($userId, $email, $type);

        $companyData = $this->dataBase->getCompany();
        $companyDomainName = $companyData['domain_name'];
        $numberOfEmployees = $companyData['number_of_employees'];

        $newNumberOfEmployeers = $user->changeEmail($newEmail, $companyDomainName, $numberOfEmployees);

        $this->dataBase->saveCompany($newNumberOfEmployeers);
        $this->dataBase->saveUser($user);
        $this->messageBus->sendEmailChangedMessage($userId, $newEmail);
    }
}