<?php

namespace App\Routes;

/**
 * Classe responsável por definir as rotas da aplicação.
 */
abstract class Routes
{
    /**
     * Retorna o mapeamento de rotas.
     */
    public static function getRoutes(): array
    {
        return [
            // Rotas de Login
            '/'                     => 'LoginController@index',
            '/login'                => 'LoginController@login',
            '/logout'               => 'LoginController@logout',

            // Rotas de usuário
            '/usuario/cadastrar'    => 'UserController@create',
            '/usuario/store'        => 'UserController@store',
            '/usuario/editar/{id}'  => 'UserController@edit',
            '/usuario/update'       => 'UserController@update',
            '/usuario/deletar/{id}' => 'UserController@delete',

            // Rotas de Clientes
            '/cliente/cadastrar'    => 'CustomerController@create',
            '/cliente/store'        => 'CustomerController@store',
            '/cliente/todos'        => 'CustomerController@show',
            '/cliente/editar/{id}'  => 'CustomerController@edit',
            '/cliente/update'       => 'CustomerController@update',
            '/cliente/deletar/{id}' => 'CustomerController@delete',

            // Rotas de Produtos
            '/produto/cadastrar'    => 'ProductController@create',
            '/produto/store'        => 'ProductController@store',
            '/produto/todos'        => 'ProductController@show',
            '/produto/editar/{id}'  => 'ProductController@edit',
            '/produto/update'       => 'ProductController@update',
            '/produto/deletar/{id}' => 'ProductController@delete',

            // Rota de Encomendas.
            '/encomenda/home'         => 'OrderController@index',
            '/encomenda/cadastrar'    => 'OrderController@create',
            '/encomenda/store'        => 'OrderController@store',
            '/encomenda/todas'        => 'OrderController@show',
            '/encomenda/editar/{id}'  => 'OrderController@edit',
            '/encomenda/update'       => 'OrderController@update',
            '/encomenda/deletar/{id}' => 'OrderController@delete',

            // Rotas de API
            '/encomenda/clientes' => 'CustomerController@customers',
            '/encomenda/produtos' => 'ProductController@products',
        ];
    }
}
