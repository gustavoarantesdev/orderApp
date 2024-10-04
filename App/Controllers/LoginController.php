<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\UserModel;
use App\Services\Authenticator;
use App\Services\UserValidator;
use App\Helpers\RedirectWithMessage;

class LoginController
{
    /**
     * Exibe o formulario de login.
     *
     * @return void
     */
    public function index()
    {
        View::render('login/index');
    }

    /**
     * Faz o login do usuário validando os dados.
     *
     * @return never
     */
    public function login(): void
    {
        // Verifica se a requisição é valida.
        $this->validateRequest();

        // Armazena os dados da superglobal $_POST.
        $userData = $this->extractUserData($_POST);

        // Verifica se o formulário está vazio.
        if (UserValidator::isFormInputEmpty($userData)) {
            RedirectWithMessage::redirect(BASE_URL, FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o e-mail é inválido.
        if (UserValidator::isInvalidUserEmail($userData->user_email)) {
            RedirectWithMessage::redirect(BASE_URL, FLASH_ERROR, 'E-mail inválido. Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (UserValidator::isInvalidUserPassword($userData->user_password)) {
            RedirectWithMessage::redirect(BASE_URL, FLASH_ERROR, 'Senha inválida. Tente novamente.');
        }

        // Verifica se foi possível fazer login.
        if (Authenticator::authenticate($userData->user_email, $userData->user_password)) {
            RedirectWithMessage::redirect(BASE_URL . '/order/home', FLASH_INFO, 'Login realizado com sucesso!');
        }

        // Se não foi possível fazer login exibe essa mensagem.
        RedirectWithMessage::redirect(BASE_URL, FLASH_ERROR, 'E-mail ou senha incorretos. Tente novamente.');
    }

    /**
     *  Faz o logout do usuário.
     *
     * @return never
     */
    public function logout(): never
    {
        Authenticator::logout();
        header('Location:' . BASE_URL);
        exit;
    }

    /**
     * Exibe o formulario para cadastro.
     *
     * @return void
     */
    public function create()
    {
        View::render('login/create');
    }

    /**
     * Armazena um novo usuario no banco de dados validando os dados.
     *
     * @return void
     */
    public function store()
    {
        // Verifica se a requisição é valida.
        $this->validateRequest();

        // Armazena os dados da superglobal $_POST.
        $userData = $this->extractUserData($_POST);

        // Instância a model.
        $userModel = new UserModel();

        // Verifica se o formulário está vazio.
        if (UserValidator::isFormInputEmpty($userData)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o nome do usuário é inválido.
        if (UserValidator::isInvalidUserName($userData->user_name)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'Nome de usuário inválido. Tente novamente.');
        }

        // Verifica se o e-mail é inválido.
        if (UserValidator::isInvalidUserEmail($userData->user_email)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'E-mail inválido. Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (UserValidator::isInvalidUserPassword($userData->user_password)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'Senha inválida. Tente novamente.');
        }

        // Verifica se as senhas são iguais.
        if (!UserValidator::areUserPasswordEqual($userData->user_password, $userData->user_password2)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'Senhas não sao iguais. Tente novamente.');
        }

        // Verifica se o e-mail já foi cadastrado.
        if ($userModel->getUserByEmail($userData->user_email)) {
            RedirectWithMessage::redirect(BASE_URL . '/login/create', FLASH_ERROR, 'Este e-mail já está em uso. Tente outro.');
        }

        // Cadastra um novo usuário.
        $userModel->createUser($userData);
        RedirectWithMessage::redirect(BASE_URL, FLASH_SUCCESS, 'Conta cadastrada com sucesso!');
    }

    /**
     * Verifica se o método da requisição é válido.
     *
     * @return void
     */
    private function validateRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location:' . BASE_URL);
            exit;
        }
    }

    /**
     * Extrai os dados do usuário, do array POST, e retorna em objeto.
     * 
     * @param array $formUserData Dados do formulário
     * @return object
     */
    private function extractUserData(array $formUserData): object
    {
        return (object) [
            'user_name'      => $formUserData['user_name'] ?? null,
            'user_email'     => $formUserData['user_email'],
            'user_password'  => $formUserData['user_password'],
            'user_password2' => $formUserData['user_password2']?? null,
        ];
    }
}
