<?php

namespace App\Helpers\customer;

/**
 * Classe abstrata para extrair os dados da superglobal $_POST.
 */
abstract class ExtractData
{
    /**
     * Extrai os dados do formulário de clientes.
     * @param array $formCustomerData Dados do formulário.
     * @return object
     */
    public static function handle(array $formCustomerData): object
    {
        return (object) [
            'id'          => $formCustomerData['id'] ?? null ,
            'name'        => $formCustomerData['name'],
            'person_type' => $formCustomerData['person_type'],
            'cpf'         => $formCustomerData['cpf'] ?? null,
            'cnpj'        => $formCustomerData['cnpj'] ?? null,
            'phone'       => $formCustomerData['phone'],
            'gender'      => $formCustomerData['gender'] ?? null,
            'birth_date'  => $formCustomerData['birth_date'] ?? null,
            'address'     => $formCustomerData['address'],
            'description' => $formCustomerData['description'] ?? null,
        ];
    }
}
