<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\UserModel;
use App\Helpers\ValidateRequest;
use App\Services\Authenticator;
use App\Services\UserValidator;
use App\Helpers\RedirectWithMessage;
use App\Helpers\RedirectIfAuthenticated;

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

        // Armazena os dados da superglobal $_POST.
        $userData = UserValidator::extractData($_POST);

        // Verifica se o formulário está vazio.
        if (UserValidator::isFormInputEmpty($userData)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o e-mail é inválido.
        if (UserValidator::isInvalidUserEmail($userData->user_email)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'E-mail inválido. Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (UserValidator::isInvalidUserPassword($userData->user_password)) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Senha inválida. Tente novamente.');
        }

        // Verifica se foi possível fazer login.
        if (Authenticator::authenticate($userData->user_email, $userData->user_password)) {
            RedirectWithMessage::handle(BASE_URL . '/order/home', FLASH_INFO, 'Login realizado com sucesso!');
        }

        // Se não foi possível fazer login exibe essa mensagem.
        RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'E-mail ou senha incorretos. Tente novamente.');
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

    /**
     * Exibe o formulario para cadastro.
     *
     * @return void
     */
    public function create()
    {
        RedirectIfAuthenticated::handle();

        View::render('login/create');
    }

    /**
     * Armazena um novo usuario no banco de dados validando os dados.
     *
     * @return void
     */
    public function store()
    {
        RedirectIfAuthenticated::handle();

        // Verifica se a requisição é valida.
        ValidateRequest::handle(BASE_URL . '/login/create');

        // Armazena os dados da superglobal $_POST.
        $userData = UserValidator::extractData($_POST);

        // Instância a model.
        $userModel = new UserModel();

        // Verifica se o formulário está vazio.
        if (UserValidator::isFormInputEmpty($userData)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o nome do usuário é inválido.
        if (UserValidator::isInvalidUserName($userData->user_name)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'Nome de usuário inválido. Tente novamente.');
        }

        // Verifica se o e-mail é inválido.
        if (UserValidator::isInvalidUserEmail($userData->user_email)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'E-mail inválido. Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (UserValidator::isInvalidUserPassword($userData->user_password)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'Senha inválida. Tente novamente.');
        }

        // Verifica se as senhas são iguais.
        if (!UserValidator::areUserPasswordEqual($userData->user_password, $userData->user_password2)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'Senhas não sao iguais. Tente novamente.');
        }

        // Verifica se o e-mail já foi cadastrado.
        if ($userModel->getUserByEmail($userData->user_email)) {
            RedirectWithMessage::handle(BASE_URL . '/login/create', FLASH_ERROR, 'Este e-mail já está em uso. Tente outro.');
        }

        // Cadastra um novo usuário.
        $userModel->createUser($userData);

        RedirectWithMessage::handle(BASE_URL, FLASH_SUCCESS, 'Conta cadastrada com sucesso!');
    }
}
