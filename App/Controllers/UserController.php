<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\login\Authenticator;
use App\Helpers\RedirectIfAuthenticated;
use App\Helpers\user\ValidateData;
use App\Helpers\ValidateRequest;
use App\Helpers\user\ExtractData;
use App\Models\UserModel;
use App\Helpers\RedirectWithMessage;

/**
 * Controlador responsável por gerenciar as requisições relacionadas aos usuários.
 *
 * Este controlador lida com a criação, atualização e
 * exclusão de usuários, além de fornecer a lógica necessária para
 * interagir com o modelo de usuários (UserModel) e renderizar as
 * respectivas views.
 */
class UserController extends Controller
{
    // Instância da Model.
    private $userModel;

    /**
     * Verifica se o usuário está logado e instância a model.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Exibe o formulario para cadastro.
     *
     * @return void
     */
    public function create()
    {
        RedirectIfAuthenticated::handle();

        View::render('user/create');
    }

    /**
     * Registra um novo usuário no banco de dados validando os dados.
     *
     * @return void
     */
    public function store(): void
    {
        RedirectIfAuthenticated::handle();

        // Verifica se a requisição é valida
        ValidateRequest::handle(BASE_URL . '/usuario/cadastrar');

        // Extrai os dados do formulário
        $userData = ExtractData::handle($_POST);

        // Verifica se o formulário está vazio.
        if (ValidateData::isFormInputEmpty($userData)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'Preencha o formulário.');
        }

        // Verifica se o nome do usuário é inválido.
        if (ValidateData::isInvalidUserName($userData->name)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'Nome de usuário inválido. <br> Tente novamente.');
        }

        // Verifica se o e-mail é inválido.
        if (ValidateData::isInvalidUserEmail($userData->email)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'E-mail inválido. <br> Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if (ValidateData::isInvalidUserPassword($userData->password)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'Senha inválida. <br> Tente novamente.');
        }

        // Verifica se as senhas são iguais.
        if (!ValidateData::areUserPasswordEqual($userData->password, $userData->password2)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'Senhas não são iguais. <br> Tente novamente.');
        }

        // Verifica se o e-mail informado, já foi cadastrado.
        if ($this->userModel->getByEmail($userData->email)) {
            RedirectWithMessage::handle(BASE_URL . '/usuario/cadastrar', FLASH_ERROR, 'Este e-mail já está em uso. <br> Tente outro.');
        }

        // Registra um novo usuário
        $this->userModel->create($userData);

        RedirectWithMessage::handle(BASE_URL, FLASH_SUCCESS, 'Conta cadastrada com sucesso!');
    }

    /**
     * Exibe o formulário para editar um usuário pelo ID informado.
     *
     * @param integer $id ID do usuário.
     * @return void
     */
    public function edit(int $id): void
    {
        // Verifica se o usuário já está logado.
        parent::__construct();

        // Armazena os dados do usuário encontrado.
        $userData = $this->userModel->getById($id);

        // Se o usuário não for encontrado, redireciona e exibe a flash message.
        if (!$userData) {
            RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_ERROR, 'Usuário não foi <b>econtrado</b>!');
        }

        // Renderiza a view, passando os dados.
        View::render('/user/edit', $userData);
    }

    /**
     * Atualiza um produto existente no banco de dados.
     *
     * Redireciona para o formulário de edição após a atualização.
     *
     * @return void
     */
    public function update(): void
    {
        // Verifica se o usuário já está logado.
        parent::__construct();

        // Verifica se a requisição é valida.
        ValidateRequest::handle(BASE_URL . '/encomenda/home');

        // Extrai e formata os dados do formulário.
        $userData = ExtractData::handle($_POST);

        // Verifica se o formulário está vazio.
        if ($userData->name == null && $userData->email == null && $userData->password == null) {
            RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_INFO, 'Dados <b>editado</b> com sucesso!');
        }

        // Verifica se o nome do usuário é inválido.
        if ($userData->name !== null && ValidateData::isInvalidUserName($userData->name)) {
            RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_ERROR, 'Nome de usuário inválido. <br> Tente novamente.');
        }

        // Verifica se o e-mail é inválido.
        if ($userData->email !== null && ValidateData::isInvalidUserEmail($userData->email)) {
            RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_ERROR, 'E-mail inválido. <br> Tente novamente.');
        }

        // Verifica se a senha é inválida.
        if ($userData->password !== null && ValidateData::isInvalidUserPassword($userData->password)) {
            RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_ERROR, 'Senha inválida. <br> Tente novamente.');
        }

        // Verifica se o e-mail informado, já foi cadastrado.
        if ($userData->email !== null && $this->userModel->getByEmail($userData->email)) {
            RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_ERROR, 'Este e-mail já está em uso. <br> Tente outro.');
        }

        // Atualiza os dados do usuário.
        $this->userModel->update($userData);

        RedirectWithMessage::handle(BASE_URL . "/usuario/editar/{$userData->id}", FLASH_INFO, 'Dados <b>editado</b> com sucesso!');
    }

    /**
     * Deleta o usuário no banco de dados.
     * Redireciona para a página de login.
     *
     * @param integer $id ID do usuário.
     * @return void
     */
    public function delete(int $id): void
    {
        // Verifica se o usuário já está logado.
        parent::__construct();

        // Deleta o produto.
        $result = $this->userModel->delete($id);

        // Se o usuário não for encontrado, redireciona e exibe a flash message.
        if ($result != true) {
            RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_ERROR, 'Usuário não foi <b>econtrado</b>!');
        }

        Authenticator::logout();
    }
}
