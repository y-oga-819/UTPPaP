<?php

declare(strict_types=1);

namespace Tests\Chapter7;

use App\Chapter7\User;
use App\Chapter7\UserType;
use App\Chapter7\DataBase;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testChangeEmail(): void
    {
        $sut = new User(1, 'test@example.com', UserType::Customer);

        $sut->changeEmail(1, 'mail@yukineko.work');

        $this->assertSame(11, DataBase::getCompany()['number_of_employees']);
        $this->assertSame('mail@yukineko.work', $sut->email);
        $this->assertSame(UserType::Employee, $sut->type);
    }
}