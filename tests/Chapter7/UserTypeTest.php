<?php

declare(strict_types=1);

namespace Tests\Chapter7;

use App\Chapter7\UserType;
use PHPUnit\Framework\TestCase;

class UserTypeTest extends TestCase
{
    public function testConstruct(): void
    {
        $sut = UserType::from(1);
        $this->assertSame(UserType::Customer, $sut);
    }

    public function testCompare(): void
    {
        $sut = UserType::Customer;

        $this->assertSame(UserType::Customer, $sut);
        $this->assertNotSame(UserType::Employee, $sut);
    }
}