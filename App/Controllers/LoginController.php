<?php

namespace App\Controllers;

use App\Core\View;
use App\Helpers\ValidateRequest;
use App\Helpers\login\Authenticator;
use App\Helpers\user\ValidateData;
use App\Helpers\user\ExtractData;
use App\Helpers\RedirectWithMessage;
use App\Helpers\RedirectIfAuthenticated;

/**
 * Classe controladora responsável por gerênciar as operações relacionadas ao
 * login do usuário.
 */
class LoginController
{
    /**
     * Exibe o formulario de login.
     *
     * @return void
     */
    public function index(): void
    {
        RedirectIfAuthenticated::handle();

        View::render('login/index');
    }

    /**
     * Faz o login do usuário validando os dados.
     *
     * @return void
     */
    public function login(): void
    {
        RedirectIfAuthenticated::handle();

        // Verifica se a requisição é valida.
        ValidateRequest::handle(BASE_URL);

        // Extrai os dados do formulário
        $userData = ExtractData::handle($_POST);

        // Verifica se o formulário está vazio.
        if (ValidateData::isFormInputEmpty($userData)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o e-mail é inválido.
        if (ValidateData::isInvalidUserEmail($userData->email)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'E-mail inválido. Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (ValidateData::isInvalidUserPassword($userData->password)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Senha inválida. Tente novamente.');
        }

        // Verifica se foi possível fazer login.
        if (Authenticator::authenticate($userData->email, $userData->password)) {
            RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_INFO, 'Login realizado com sucesso!');
        }

        // Se não foi possível fazer login exibe essa mensagem.
        RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'E-mail ou senha incorretos. <br> Tente novamente.');
    }

    /**
     * Faz o logout do usuário.
     *
     * @return void
     */
    public function logout(): void
    {
        Authenticator::logout();
    }
}
