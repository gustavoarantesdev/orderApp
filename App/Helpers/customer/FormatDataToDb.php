<?php

namespace App\Helpers\customer;

/**
 * Formata os dados antes de armazenar no banco de dados.
 */
abstract class FormatDataToDb
{
    /**
     * Fomata os dados do cliente.
     * @param object $data Dados do cliente.
     * @return object
     */
    public static function handle(object $data): object
    {
        if (!empty($data->cpf)) {
            $data->cpf = self::cpf($data->cpf);
        }

        if (!empty($data->cnpj)) {
            $data->cnpj = self::cnpj($data->cnpj);
        }

        if (!empty($data->phone)) {
            $data->phone = self::phone($data->phone);
        }

        return $data;
    }

    /**
     * Formata o número do CPF.
     * @param string $cpf CPF do cliente.
     * @return string
     */
    private static function cpf(string $cpf): string
    {
        return str_replace(['.', '-'], '', $cpf);
    }

    /**
     * Formata o número do CNPJ.
     * @param string $cnpj CNPJ do cliente.
     * @return string
     */
    private static function cnpj(string $cnpj): string
    {
        return str_replace(['.', '/', '-'], '', $cnpj);
    }

    /**
     * Formata o número do telefone.
     * @param string $phone Telefone do cliente.
     * @return string
     */
    private static function phone(string $phone): string
    {
        return str_replace(['(', ')', '-'], '', $phone);
    }
}
