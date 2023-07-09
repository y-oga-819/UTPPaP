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

    public function changeEmail(int $userId, string $newEmail): string
    {
        $data = $this->dataBase->getUserById($userId);
        $user = UserFactory::create($data);

        $companyData = $this->dataBase->getCompany();
        $company = CompanyFactory::create($companyData);

        try {
            $user->changeEmail($newEmail, $company);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $this->dataBase->saveCompany($company);
        $this->dataBase->saveUser($user);

        foreach ($user->emailChangedEvents as $event) {
            $this->messageBus->sendEmailChangedMessage($event->userId, $event->newEmail);
        }

        return 'OK';
    }
}