<?php
declare(strict_types=1);

namespace App\Service;

class CodeGeneratorService
{
    private const CHARS = '0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';

    public static function generate(int $length = 7): string
    {
        return substr(str_shuffle(self::CHARS), 0, $length);
    }
}
