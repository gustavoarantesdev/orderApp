<?php

namespace App\Helpers\User;

/**
 * Helper responsável por verificar os dados do formulário de login e cadastro de usuário.
 */
abstract class ValidateData
{
    /**
     * Verifia se o formulário está vazio.
     *
     * @param object $formInput
     * @return bool
     */
    public static function isFormInputEmpty(object $formInput): bool
    {
        return empty($formInput->name) && $formInput->name !== null
            || empty($formInput->email) || empty($formInput->password)
            || empty($formInput->password2) && $formInput->password2 !== null;
    }

    /**
     * Verifica se o nome do usuário é inválido.
     *
     * Verifica se o nome do usuário é menor que 3 caracteres, se é diferente
     * do padrão do RegEx, e se é maior que 150 caracteres.
     *
     * @param string $name nome do usuário
     * @return bool
     */
    public static function isInvalidUserName(string $name): bool
    {
        return strlen($name) < 3
            || !preg_match("/^[A-Za-z .'-]+$/", $name)
            || strlen($name) > 150;
    }

    /**
     * Verifica se o e-mail do usuário é inválido.
     *
     * Verifica se o e-mail é diferente do padrão do RegEx, e se é maior
     * que 150 caracteres.
     *
     * @param string $email E-mail do usuário
     * @return bool
     */
    public static function isInvalidUserEmail(string $email): bool
    {
        return !preg_match("/^[a-z0-9.]+@[a-z0-9]+\.[a-z]{2,4}$/", $email)
            || strlen($email) > 150;
    }

    /**
     * Verifica se a senha do usuáro está no tamanho correto.
     *
     * @param string $password Senha do usuário.
     * @return bool
     */
    public static function isInvalidUserPassword(string $password): bool
    {
        return strlen($password) < 5;
    }

    /**
     * Verifica se as senhas do usuário são iguais.
     *
     * @param string $password Senha do usuário.
     * @param string $password2 Senha de confirmação do usuário.
     * @return bool
     */
    public static function areUserPasswordEqual(string $password, string $password2)
    {
        return $password === $password2;
    }
}