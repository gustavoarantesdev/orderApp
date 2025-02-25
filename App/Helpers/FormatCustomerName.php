<?php

namespace App\Helpers;

/**
 * Helper responsável por formatar o nome do cliente.
 */
abstract class FormatCustomerName
{
    /**
     * Formata o nome do cliente para apresentar somente primeiro e último nome.
     * Se houver somente um nome e ele for maior que 20 caracteres limita.
     *
     * @param string $orderClientName
     * @return string
     */
    public static function handle(string $name)
    {
        $name = explode(' ', $name);

        if (count($name) > 1) {
            $firstName = reset($name);
            $lastName = end($name);
            return $name = "$firstName $lastName";
        }

        return self::reduceString($name[0]);
    }

    /**
     * Reduz uma string se ele houver mais de 20 caracteres.
     *
     * @param string $str String a ser reduzida.
     * @return string
     */
    private static function reduceString(string $str): string
    {
        return (strlen($str) <= 20) ? $str : substr($str, 0, 20) . '...';
    }
}