<?php

declare(strict_types=1);

namespace Tests\Chapter7;

use App\Chapter7\User;
use App\Chapter7\UserType;
use App\Chapter7\DataBase;
use App\Chapter7\UserController;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testChangeEmail(): void
    {
        // Arrange
        $user = new User(1, 'test@example.com', UserType::Customer, false);

        $dataBase = new DataBase();
        $dataBase->saveUser($user);

        // Act
        $sut = new UserController();
        $actual = $sut->changeEmail(1, 'mail@yukineko.work');

        // Assert
        $actualUser = $dataBase->getUserById(1);

        $this->assertSame('OK', $actual);
        $this->assertSame(11, $dataBase->getCompany()['number_of_employees']);
        $this->assertSame('mail@yukineko.work', $actualUser['email']);
        $this->assertSame(UserType::Employee, $actualUser['user_type']);
    }

    public function testChangeEmailFailure(): void
    {
        // Arrange
        $user = new User(1, 'test@example.com', UserType::Customer, true);

        $dataBase = new DataBase();
        $dataBase->saveUser($user);

        // Act
        $sut = new UserController();
        $actual = $sut->changeEmail(1, 'mail@yukineko.work');

        // Assert
        $actualUser = $dataBase->getUserById(1);

        $this->assertSame("Can't change a confirmed email", $actual);
        $this->assertSame(11, $dataBase->getCompany()['number_of_employees']);
        $this->assertSame('test@example.com', $actualUser['email']);
        $this->assertSame(UserType::Customer, $actualUser['user_type']);
    }
}