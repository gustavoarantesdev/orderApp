<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Core\View;

class OrderController extends View
{
    /**
     * Página inicial com todos os pedidos.
     */
    public function index(): void
    {
        $orderModel = new OrderModel;

        $data = $orderModel->getOrders();

        View::render('order/index', $data);
    }

    /**
     * Exibe o formulário para cadastro de novo pedido.
     */
    public function create(): void
    {
        View::render('order/create');
    }

    /**
     * Armazena um novo pedido.
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_title'])) {
            header('Location:' . BASE_URL . '/create' );
            exit;
        }

        $data = $this->extractOrderData($_POST);

        $orderModel = new OrderModel();
        $orderModel->createOrder($data);

        header('Location:' . BASE_URL);
    }

    /**
     * Exibe todos os pedidos.
     */
    public function show(): void
    {
        $orderModel = new OrderModel();
        $data = $orderModel->getAllOrders();

        View::render('order/show', $data);
    }

    /**
     * Exibe um formulário para edição de um pedido.
     */
    public function edit(int $id): void
    {
        $orderModel = new OrderModel();
        $data = $orderModel->fetchOrderById($id);

        if ($data == null) {
            header('Location:' . BASE_URL);
            exit;
        }

        View::render('order/edit', $data);
    }

    /**
     * Atualiza um pedido no banco de dados.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_title'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $data = $this->extractOrderData($_POST);

        $orderModel = new OrderModel();
        $orderModel->updateOrder($data);

        header('Location:' . BASE_URL . '/edit/' . $_POST['order_id']);
        exit;
    }

    /**
     * Delete um pedido no banco de dados.
     */
    public function delete(int $id): void
    {
        $orderModel = new OrderModel();
        $data = $orderModel->deleteOrder($id);

        if (is_null($data)) {
            header('Location:' . BASE_URL);
            exit;
        }

        header('Location:' . BASE_URL);
    }

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
