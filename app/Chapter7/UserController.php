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
        $user = UserFactory::create($data);

        $companyData = $this->dataBase->getCompany();
        $company = CompanyFactory::create($companyData);

        $user->changeEmail($newEmail,$company);

        $this->dataBase->saveCompany($company);
        $this->dataBase->saveUser($user);
        $this->messageBus->sendEmailChangedMessage($userId, $newEmail);
    }
}