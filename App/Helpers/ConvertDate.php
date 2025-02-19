<?php

namespace App\Helpers;

/**
 * Classe responsável por converter a data do padrão en_US para pt_BR.
 */
class ConvertDate
{
    public static function handle(string $date): string
    {
        return date("d/m/y h:i", strtotime($date));
    }
}
