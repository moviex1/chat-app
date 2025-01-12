<?php

declare(strict_types=1);

namespace App\Controller\Message\Send;

final readonly class Request
{
    public function __construct(
        public string $content,
    )
    {
    }
}