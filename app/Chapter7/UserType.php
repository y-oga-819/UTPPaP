<?php

declare(strict_types=1);

namespace App\Chapter7;

enum UserType: int {
    case Customer = 1;
    case Employee = 2;

    public function equals(self $enum): bool
    {
        return $this->value === $enum->value && static::class === $enum::class;
    }
}