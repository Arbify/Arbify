<?php

declare(strict_types=1);

namespace App\Utils;

class RandomPassword
{
    public static function generate(int $length): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*';

        $password = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $password[] = $alphabet[$n];
        }

        return implode($password);
    }
}
