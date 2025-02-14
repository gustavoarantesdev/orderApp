<?php

namespace App\Controllers;

use App\Core\View;
use App\Helpers\order\ExtractData;
use App\Models\OrderModel;
use App\Services\Authenticator;
use App\Helpers\RedirectWithMessage;
use App\Helpers\ValidateRequest;

/**
 * Class OrderController
 *
 * Controlador responsável por gerenciar as requisições relacionadas às encomendas.
 *
 * Este controlador lida com a exibição de encomendas, criação, atualização e
 * exclusão de encomendas, além de fornecer a lógica necessária para
 * interagir com o modelo de encomendas (OrderModel) e renderizar as
 * respectivas views.
 */
class OrderController
{
    /**
     * Verifica se o usuário está logado.
     */
    public function __construct()
    {
        if (!Authenticator::isAuthenticated()) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Faça login para acessar.');
        }
    }

    /**
     * Exibe a lista de todas as encomendas disponíveis na página inicial.
     *
     * @return void
     */
    public function index(): void
    {
        // Instância a model.
        $orderModel = new OrderModel;

        // Armazena os dados do retorno da model.
        $ordersData = $orderModel->getOrders();

        // Renderiza a view passando os dados.
        View::render('/order/index', $ordersData);
    }

    /**
     * Exibe o formulário para cadastrar uma nova encomenda.
     *
     * @return void
     */
    public function create(): void
    {
        // Renderiza a view.
        View::render('/order/create');
    }

    /**
     * Armazena uma nova encomenda no banco de dados.
     *
     * Redireciona para a página inicial após o armazenamento.
     *
     * @return void
     */
    public function store(): void
    {
        // Verifica se a requisição é válida.
        ValidateRequest::handle('/encomenda/store');

        // Extrai os dados do formulário
        $orderData = ExtractData::handle($_POST);

        // Instância a model
        $orderModel = new OrderModel();

        // Registra a encomenda
        $orderModel->createOrderWithItems($orderData);

        // Redireciona e exibe a flash message.
        RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_SUCCESS, 'Encomenda <b>cadastrada</b> com sucesso!');
    }

    /**
     * Exibe todas as encomendas cadastradas.
     */
    public function show(): void
    {
        // Instância a model.
        $orderModel = new OrderModel();

        // Armazena os dados do retorno da model.
        $data = $orderModel->getAllOrders();

        // Renderiza a view, passando os dados.
        View::render('/order/show', $data);
    }

    /**
     * Exibe o formulário para editar uma encomenda pelo ID informado
     *
     * @param integer $id ID da encomenda a ser editada.
     * @return void
     */
    public function edit(int $id): void
    {
        // Instância a model.
        $orderModel = new OrderModel();

        // Armazena os dados do retorno da model.
        $orderData = $orderModel->fetchOrderById($id);

        // Se a encomenda não for encontrada, redireciona e exibe a flash message.
        if (is_null($orderData) || $orderData == false) {
            RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_ERROR, 'Encomenda não foi <b>econtrada</b>!');
        }

        // Renderiza a view, passando os dados.
        View::render('/order/edit', $orderData);
    }

    /**
     * Atualiza uma encomenda existente no banco de dados.
     *
     * Redireciona para o formulário de edição após a atualização.
     *
     * @return void
     */
    public function update(): void
    {
        // Verifica se a requisição é válida.
        ValidateRequest::handle(BASE_URL . '/encomenda/update');

        // Extrai os dados do formulário
        $orderData = ExtractData::handle($_POST);

        // Instância a model.
        $orderModel = new OrderModel();

        // Armazena os dados do retorno da model.
        $orderModel->updateOrderWithItems($orderData);

        // Redireciona e exibe a flash message.
        RedirectWithMessage::handle(BASE_URL . "/encomenda/editar/$orderData->id", FLASH_INFO, 'Encomenda <b>editada</b> com sucesso!');
    }

    /**
     * Remove uma encomenda do banco de dados.
     *
     * Redireciona para a página inicial após a exclusão.
     *
     * @param integer $orderId
     * @return void
     */
    public function delete(int $orderId): void
    {
        // Instância a model.
        $orderModel = new OrderModel();

        // Deleta uma encomenda no banco de dados.
        $result = $orderModel->deleteOrder($orderId);

        // Se a encomenda não for encontrada, redireciona e exibe a flash message.
        if ($result != true) {
            RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_ERROR, 'Encomenda não foi <b>econtrada</b>!');
        }

        // Redireciona e exibe a flash message.
        RedirectWithMessage::handle(BASE_URL . '/encomenda/home', FLASH_WARNING, 'Encomenda <b>excluída</b> com sucesso!');
    }
}
