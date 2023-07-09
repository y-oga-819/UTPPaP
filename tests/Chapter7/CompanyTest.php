<?php

declare(strict_types=1);

namespace Tests\Chapter7;

use App\Chapter7\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    /**
     * @dataProvider provideIsEmailCorporate
     */
    public function testIsEmailCorporate(string $email, bool $expected): void
    {
        $sut = new Company('mycorp.com', 1);

        $actual = $sut->isEmailCorporate($email);

        $this->assertSame($expected, $actual);
    }

    public static function provideIsEmailCorporate(): array
    {
        return [
            '従業員のメールアドレス' => [
                'email' => 'email@mycorp.com',
                'expected' => true,
            ],
            '非従業員のメールアドレス' => [
                'email' => 'email@gmail.com',
                'expected' => false,
            ],
        ];
    }
}