<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Core\View;

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
class OrderController extends View
{
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
        $data = $orderModel->getOrders();

        // Renderiza a view passando os dados.
        View::render('order/index', $data);
    }

    /**
     * Exibe o formulário para cadastrar uma nova encomenda.
     *
     * @return void
     */
    public function create(): void
    {
        // Renderiza a view.
        View::render('order/create');
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
        // Verifica se a requisição é valida.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_title'])) {
            header('Location:' . BASE_URL . '/create' );
            exit;
        }

        // Armazena os dados da superglobal $_POST.
        $data = $this->extractOrderData($_POST);

        // Instância a model.
        $orderModel = new OrderModel();

        // Registra uma nova encomenda.
        $orderModel->createOrder($data);

        // Redireciona para a página inicial.
        header('Location:' . BASE_URL);
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
        View::render('order/show', $data);
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
        $data = $orderModel->fetchOrderById($id);

        // Se a encomenda não for encontrada, redireciona.
        if ($data == null) {
            header('Location:' . BASE_URL);
            exit;
        }

        // Renderiza a view, passando os dados.
        View::render('order/edit', $data);
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
        // Verifica se a requisição é valida.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_title'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Armazena os dados da superglobal $_POST.
        $data = $this->extractOrderData($_POST);

        // Instância a model.
        $orderModel = new OrderModel();

        // Armazena os dados do retorno da model.
        $orderModel->updateOrder($data);

        // Redireciona para a página de edição.
        header('Location:' . BASE_URL . '/edit/' . $_POST['order_id']);
        exit;
    }

    /**
     * Delete um pedido no banco de dados.
     */

    /**
     * Remove uma encomenda do banco de dados.
     * 
     * Redireciona para a página inicial após a exclusão.
     *
     * @param integer $id ID da encomenda a ser deletada.
     * @return void
     */
    public function delete(int $id): void
    {
        // Instância a model.
        $orderModel = new OrderModel();

        // Deleta uma encomenda no banco de dados.
        $data = $orderModel->deleteOrder($id);

        // Se a encomenda não for encontrada, redireciona.
        if (is_null($data)) {
            header('Location:' . BASE_URL);
            exit;
        }

        // Redireciona para a página inicial.
        header('Location:' . BASE_URL);
    }

    /**
     * Extrai os dados da encomenda do array de dados recebidos via POST.
     *
     * @param array $postData Dados da encomenda recebidos.
     * @return array Dados da encomenda extraídos e organizados.
     */
    private function extractOrderData(array $postData): array
    {
        return [
            'order_id'             => $postData['order_id'] ?? null,
            'order_title'          => $postData['order_title'],
            'client_name'          => $postData['client_name'],
            'completion_date'      => $postData['completion_date'],
            'completion_time'      => $postData['completion_time'],
            'order_price'          => $postData['order_price'],
            'payment_method'       => $postData['payment_method'],
            'payment_installments' => $postData['payment_installments'],
            'order_description'    => $postData['order_description'],
            'is_completed'         => $postData['is_completed'] ?? false,
        ];
    }
}
