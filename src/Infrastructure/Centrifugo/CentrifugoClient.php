<?php

declare(strict_types=1);

namespace App\Infrastructure\Centrifugo;

use phpcent\Client;

final readonly class CentrifugoClient
{
    public function __construct(
        private Client $client,
    ) {
    }

    public function publish(string $channel, array $data): mixed
    {
        return $this->client->publish(channel: $channel, data: $data);
    }

    public function generateConnectionToken(string $id, int $expiration = 0): string
    {
        $expiration = $expiration > 0 ? time() + $expiration : 0;

        return $this->client->generateConnectionToken(userId: $id, exp: $expiration);
    }

    public function generateSubscriptionToken(string $id, string $channel, int $expiration = 0): string
    {
        $expiration = $expiration > 0 ? time() + $expiration : 0;

        return $this->client->generateSubscriptionToken(userId: $id, channel: $channel, exp: $expiration);
    }
}
