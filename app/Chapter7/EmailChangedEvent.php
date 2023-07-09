<?php

declare(strict_types=1);

namespace App\Chapter7;

class EmailChangedEvent
{
    public function __construct(
        public readonly int $userId,
        public readonly string $newEmail,
    ) {
    }
}