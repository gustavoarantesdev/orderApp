<?php

namespace App\Controllers;

class OrderController
{
    /**
     * Página inicial com todos os pedidos.
     */
    public function index()
    {
        echo '<h1>Todos os pedidos disponiveis</h1>';
    }

    /**
     * Exibe o formulário para cadastro de novo pedido.
     */
    public function create()
    {
        echo '<h1>Cadastrar novo pedidos</h1>';
        //
    }

    /**
     * Armazena um novo pedido.
     */
    public function store(string $id)
    {
        echo '<h1>Todos os pedidos</h1>';
        //
    }

    /**
     * Exibe todos os pedidos.
     */
    public function show()
    {
        echo '<h1>Todos os pedidos</h1>';
        //
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
