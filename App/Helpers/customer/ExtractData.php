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
            'name'        => $formCustomerData['name'] ,
            'person_type' => $formCustomerData['person_type'],
            'cpf'         => !empty($formCustomerData['cpf']) ? $formCustomerData['cpf'] : null,
            'cnpj'        => !empty($formCustomerData['cnpj']) ? $formCustomerData['cnpj'] : null,
            'phone'       => $formCustomerData['phone'],
            'gender'      => !empty($formCustomerData['gender']) ? $formCustomerData['gender'] : null,
            'birth_date'  => !empty($formCustomerData['birth_date']) ? $formCustomerData['birth_date'] : null,
            'address'     => $formCustomerData['address'],
            'description' => !empty($formCustomerData['description']) ? $formCustomerData['description'] : null,
        ];
    }
}
