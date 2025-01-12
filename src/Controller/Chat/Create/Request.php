<?php

declare(strict_types=1);

namespace App\Controller\Chat\Create;

final readonly class Request
{
    public function __construct(
        public string $name,
    )
    {
    }
}