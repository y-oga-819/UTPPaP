<?php

declare(strict_types=1);

namespace Tests\Chapter7;

use PHPUnit\Framework\TestCase;
use App\Chapter7\Company;
use App\Chapter7\EmailChangedEvent;
use App\Chapter7\User;
use App\Chapter7\UserType;

use function PHPUnit\Framework\assertSame;

class UserTest extends TestCase
{
    /**
     * @dataProvider provideChangeEmail
     */
    public function testChaneEmail(array $arrange, array $expected)
    {
        $company = new Company('mycorp.com', 1);
        $sut = new User(1, $arrange['old_email'], $arrange['user_type'], false);

        $sut->changeEmail($arrange['new_email'], $company);

        $this->assertSame($expected['number_of_employees'], $company->numberOfEmployees);
        $this->assertSame($expected['email'], $sut->email);
        $this->assertSame($expected['user_type'], $sut->type);
        $this->assertEquals($expected['event'], array_shift($sut->emailChangedEvents));
    }

    public static function provideChangeEmail(): array
    {
        return [
            'メールアドレスを非従業員のものから従業員のものに変える' => [
                'arrange' => [
                    'old_email' => 'user@gmail.com',
                    'user_type' => UserType::Customer,
                    'new_email' => 'new@mycorp.com',
                ],
                'expected' => [
                    'number_of_employees' => 2,
                    'email' => 'new@mycorp.com',
                    'user_type' => UserType::Employee,
                    'event' => new EmailChangedEvent(1, 'new@mycorp.com'),
                ],
            ],
            'メールアドレスを従業員のものから非従業員のものに変える' => [
                'arrange' => [
                    'old_email' => 'user@mycorp.com',
                    'user_type' => UserType::Employee,
                    'new_email' => 'new@gmail.com',
                ],
                'expected' => [
                    'number_of_employees' => 0,
                    'email' => 'new@gmail.com',
                    'user_type' => UserType::Customer,
                    'event' => new EmailChangedEvent(1, 'new@gmail.com'),
                ],
            ],
            'ユーザーの種類を変えずにメールアドレスを変える' => [
                'arrange' => [
                    'old_email' => 'user@gmail.com',
                    'user_type' => UserType::Customer,
                    'new_email' => 'new@gmail.com',
                ],
                'expected' => [
                    'number_of_employees' => 1,
                    'email' => 'new@gmail.com',
                    'user_type' => UserType::Customer,
                    'event' => new EmailChangedEvent(1, 'new@gmail.com'),
                ],
            ],
            'メールアドレスを同じメールアドレスで変える' => [
                'arrange' => [
                    'old_email' => 'user@gmail.com',
                    'user_type' => UserType::Customer,
                    'new_email' => 'user@gmail.com',
                ],
                'expected' => [
                    'number_of_employees' => 1,
                    'email' => 'user@gmail.com',
                    'user_type' => UserType::Customer,
                    'event' => null,
                ],
            ],
        ];
    }

    public function testChaneEmailFailure(): void
    {
        $company = new Company('mycorp.com', 1);
        $sut = new User(1, 'email@gmail.com', UserType::Customer, true);        

        $this->expectException(\Exception::class);
        $sut->changeEmail('new@mycorp.com', $company);
    }
}