<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CustomerModel;
use App\Core\View;
use App\Helpers\customer\ExtractData;
use App\Helpers\customer\FormatDataToDb;
use App\Helpers\ConvertDate;
use App\Helpers\ValidateRequest;
use App\Helpers\RedirectWithMessage;

/**
 * Class CustomerController
 *
 * Controlador responsável por gerenciar as requisições relacionadas aos clientes.
 *
 * Este controlador lida com a exibição de clientes, criação, atualização e
 * exclusão de clientes, além de fornecer a lógica necessária para
 * interagir com o modelo de clientes (CustomerModel) e renderizar as
 * respectivas views.
 */
class CustomerController extends Controller
{
    // Instância da CustomerModel.
    private $customerModel;

    /**
     * Verifica se o usuário está logado e instância a model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->customerModel = new CustomerModel();
    }

    public function index(): void
    {

    }

    /**
     * Exibe o formulário para cadastrar um novo cliente.
     *
     * @return void
     */
    public function create(): void
    {
        View::render('/customer/create');
    }

    /**
     * Armazena um novo cliente no banco de dados.
     *
     * Redireciona para a página de clientes.
     *
     * @return void
     */
    public function store(): void
    {
        // Verifica se a requisição é valida.
        ValidateRequest::handle('/cliente/cadastrar');

        // Extrai e formata os dados do formulário.
        $customerData = $this->processCustomerData($_POST);

        // Verifica se o cliente já está cadastrado.
        $this->customerExists($customerData);

        // Cadastra um novo cliente.
        $this->customerModel->create($customerData);

        RedirectWithMessage::handle(BASE_URL . '/cliente/todos', FLASH_SUCCESS, 'Cliente <b>cadastrado</b> com sucesso!');
    }

    /**
     * Exibe todos os clientes cadastrados.
     *
     * @return void
     */
    public function show(): void
    {
        // Armazena os dados de todos clientes.
        $allData = $this->customerModel->getAll();

        // Renderiza a view, passando os dados.
        View::render('/customer/show', $allData);
    }

    /**
     * Exibe o formulário para editar um cliente pelo ID informado
     *
     * @param integer $id ID do cliente.
     * @return void
     */
    public function edit(int $id): void
    {
        // Armazena os dados do cliente encontrado.
        $allData = $this->customerModel->getById($id);

        // Se o cliente não for encontrado, redireciona e exibe a flash message.
        if (!$allData) {
            RedirectWithMessage::handle(BASE_URL . '/customer/show', FLASH_ERROR, 'Cliente não foi <b>econtrado</b>!');
        }

        // Converte a data de cadastro do cliente para formato pt_BR.
        $allData->created_at = ConvertDate::handle($allData->created_at);

        // Renderiza a view, passando os dados.
        View::render('/customer/edit', $allData);
    }

    /**
     * Atualiza um cliente existente no banco de dados.
     *
     * Redireciona para o formulário de edição após a atualização.
     *
     * @return void
     */
    public function update(): void
    {
        // Verifica se a requisição é valida.
        ValidateRequest::handle(BASE_URL . '/cliente/todos');

        // Extrai e formata os dados do formulário.
        $customerData = $this->processCustomerData($_POST);

        // Atualiza os dados do cliente.
        $this->customerModel->update($customerData);

        RedirectWithMessage::handle(BASE_URL . "/cliente/editar/{$customerData->id}", FLASH_INFO, 'Cliente <b>editado</b> com sucesso!');
    }

    /**
     * Remove um cliente no banco de dados.
     *
     * Redireciona para a página todos os clientes após a exclusão.
     *
     * @param integer $id ID do cliente.
     * @return void
     */
    public function delete(int $id): void
    {
        // Deleta o cliente.
        $result = $this->customerModel->delete($id);

        // Se o cliente não for encontrado, redireciona e exibe a flash message.
        if ($result != true) {
            RedirectWithMessage::handle(BASE_URL . '/cliente/todos', FLASH_ERROR, 'Cliente não foi <b>econtrado</b>!');
        }

        RedirectWithMessage::handle(BASE_URL . '/cliente/todos', FLASH_WARNING, 'Cliente <b>excluído</b> com sucesso!');
    }

    /**
     * Extrai os dados do formulário e formata os dados.
     *
     * @param array $data Dados do cliente.
     * @return object
     */
    private function processCustomerData(array $data): object
    {
        $customerData = ExtractData::handle($data);

        return FormatDataToDb::handle($customerData);
    }

    /**
     * Verifica se o CPF ou CNPJ já está cadastrado.
     * 
     * @param object $data Dados do cliente.
     * @return void
     */
    private function customerExists(object $data): void
    {
        // Verifica se o CPF já existe.
        if ($data->cpf != null) {
            if ($this->customerModel->cpfExists($data->cpf)) {
                RedirectWithMessage::handle(BASE_URL . '/cliente/cadastrar', FLASH_ERROR, 'Já existe um cliente com esse <b>CPF</b>.');
            }
        }

        // Verifica se o CNPJ já existe.
        if ($data->cnpj != null) {
            if ($this->customerModel->cnpjExists($data->cnpj)) {
                RedirectWithMessage::handle(BASE_URL . '/cliente/cadastrar', FLASH_ERROR, 'Já existe um cliente com esse <b>CNPJ</b>.');
            }
        }
    }
}
