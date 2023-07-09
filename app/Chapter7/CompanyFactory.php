<?php

declare(strict_types=1);

namespace App\Chapter7;

class CompanyFactory
{
    public static function create(array $data): Company
    {
        $domainName = $data['domain_name'];
        $numberOfEmployees = $data['number_of_employees'];

        return new Company($domainName, $numberOfEmployees);
    }
}