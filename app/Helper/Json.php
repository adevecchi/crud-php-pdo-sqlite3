<?php

namespace App\Helper;

final class Json
{
    private function __construct() {}

    public static function encode(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public static function decode(string $data): object
    {
        return json_decode($data);
    }
}