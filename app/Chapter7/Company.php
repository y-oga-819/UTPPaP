<?php

declare(strict_types=1);

namespace App\Chapter7;

class Company
{
    public function __construct(
        public string $domainName,
        public int $numberOfEmployees,
    ) {
    }

    public function changeNumberOfEmployees(int $delta): void
    {
        if ($this->numberOfEmployees + $delta < 0) {
            throw new \Exception();
        }

        $this->numberOfEmployees += $delta;
    }

    public function isEmailCorporate(string $email): bool
    {
        $emailDomain = explode('@', $email)[1];
        return $this->domainName === $emailDomain;
    }
}