<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\OrderModel;

class OrderController extends View
{
    /**
     * Página inicial com todos os pedidos.
     */
    public function index()
    {
        $orderModel = new OrderModel;

        $data = $orderModel->getOrders();

        View::render('index', ['data' => $data]);
    }

    /**
     * Exibe o formulário para cadastro de novo pedido.
     */
    public function create()
    {
        View::render('newOrder');
    }

    /**
     * Armazena um novo pedido.
     */
    public function store()
    {
        if (!isset($_POST['order_title'])) {
            header('Location:' . BASE_URL . '/create' );
        }

        $data = [
            'order_title'          => $_POST['order_title'],
            'client_name'          => $_POST['client_name'],
            'completion_date'      => $_POST['completion_date'],
            'completion_time'      => $_POST['completion_time'],
            'order_price'          => $_POST['order_price'],
            'payment_method'       => $_POST['payment_method'],
            'payment_installments' => $_POST['payment_installments'],
            'order_description'    => $_POST['order_description'],
        ];

        $orderModel = new OrderModel();
        $orderModel->createOrder($data);

        header('Location:' . BASE_URL);
    }

    /**
     * Exibe todos os pedidos.
     */
    public function show()
    {
        $orderModel = new OrderModel();
        $data = $orderModel->getAllOrders();

        View::render('allOrders', $data);
    }

    /**
     * Exibe um formulário para edição de um pedido.
     */
    public function edit(string $id)
    {
        echo "<h1>Editar um pedidos {$id}</h1>";
        //
    }

    /**
     * Atualiza um pedido no banco de dados.
     */
    public function update(string $id)
    {
        echo '<h1>Todos os pedidos</h1>';
        //
    }

    /**
     * Delete um pedido no banco de dados.
     */
    public function delete(string $id)
    {
        echo '<h1>Deleta um pedidos</h1>';
        //
    }
}
