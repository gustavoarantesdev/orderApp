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
     * Extrai os dados do array recebidos via POST.
     *
     * @param array $formUserData
     * @return object
     */
    public static function extractData(array $formUserData): object
    {
        return (object) [
            'name'      => $formUserData['name'] ?? null,
            'email'     => $formUserData['email'],
            'password'  => $formUserData['password'],
            'password2' => $formUserData['password2']?? null,
        ];
    }

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
