<?php

namespace App\Helpers\user;

/**
 * Classe abstrata para extrair os dados da superglobal $_POST.
 */
abstract class ExtractData
{
    /**
     * Extrai os dados do formulário de usuário.
     * @param array $formUserData Dados do formulário.
     * @return object
     */
    public static function handle(array $formUserData): object
    {
        return (object) [
            'name'      => $formUserData['name'] ?? null,
            'email'     => $formUserData['email'],
            'password'  => $formUserData['password'],
            'password2' => $formUserData['password2']?? null,
        ];
    }
}

