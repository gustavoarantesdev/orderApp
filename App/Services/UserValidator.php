<?php

namespace App\Services;

/**
 * Classe responsável por centralizar a validação dos dados do usuário.
 *
 * Essa classe faz verificações como se o formulário foi totoalmente preenchido,
 * verifica se o nome, e-mail, e senha estão fora do padrão e verifica se as
 * senhas são iguais.
 */
abstract class UserValidator
{
    /**
     * Verifia se o formulário está vazio.
     *
     * @param object $formInput
     * @return bool
     */
    public static function isFormInputEmpty(object $formInput): bool
    {
        return empty($formInput->user_name) && $formInput->user_name !== null
            || empty($formInput->user_email) || empty($formInput->user_password)
            || empty($formInput->user_password2) && $formInput->user_password2 !== null;
    }

    /**
     * Verifica se o nome do usuário é inválido.
     *
     * Verifica se o nome do usuário é menor que 3 caracteres, se é diferente
     * do padrão do RegEx, e se é maior que 150 caracteres.
     *
     * @param string $userName
     * @return bool
     */
    public static function isInvalidUserName(string $userName): bool
    {
        return strlen($userName) < 3
            || !preg_match("/^[A-Za-z .'-]+$/", $userName)
            || strlen($userName) > 150;
    }

    /**
     * Verifica se o e-mail do usuário é inválido.
     *
     * Verifica se o e-mail é diferente do padrão do RegEx, e se é maior
     * que 150 caracteres.
     *
     * @param string $userEmail O e-mail do usuário.
     * @return bool
     */
    public static function isInvalidUserEmail(string $userEmail): bool
    {
        return !preg_match("/^[a-z0-9.]+@[a-z0-9]+\.[a-z]{2,4}$/", $userEmail)
            || strlen($userEmail) > 150;
    }

    /**
     * Verifica se a senha do usuáro está no tamanho correto.
     *
     * @param string $userPassword
     * @return bool
     */
    public static function isInvalidUserPassword(string $userPassword): bool
    {
        return strlen($userPassword) < 5;
    }

    /**
     * Verifica se as senhas do usuário são iguais.
     *
     * @param string $userPassword
     * @param string $userPassword2
     * @return bool
     */
    public static function areUserPasswordEqual(string $userPassword, string $userPassword2)
    {
        return $userPassword === $userPassword2;
    }
}
