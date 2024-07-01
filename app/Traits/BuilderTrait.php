<?php

namespace App\Traits;

trait BuilderTrait
{
    /**
     * @param int $statusCode
     * @param array $body
     * @param string $message
     * @param array $headers
     * @return array
     */
    public function responseBuilder(int $statusCode, string $message = "", array $body = [], array $headers = []): array
    {
        return [
            "status" => $statusCode,
            "data" => $body,
            "message" => $message,
            "headers" => $headers
        ];
    }
}