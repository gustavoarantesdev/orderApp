<?php

namespace App\Helpers;

/**
 * Classe responsável por converter a data do padrão en_US para pt_BR.
 */
class ConvertDate
{
    public static function handle($date)
    {
        return date("d/m/Y h:i", strtotime($date));
    }
}
