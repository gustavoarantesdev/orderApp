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
            // Rotas de Login.
            '/'                => 'LoginController@index',
            '/login'           => 'LoginController@login',
            '/login/cadastrar' => 'LoginController@create',
            '/login/store'     => 'LoginController@store',
            '/logout'          => 'LoginController@logout',

            // Rota de Encomendas.
            '/home'                   => 'OrderController@index',
            '/encomenda/cadastrar'    => 'OrderController@create',
            '/order/store'            => 'OrderController@store',
            '/encomenda/todas'        => 'OrderController@show',
            '/encomenda/editar/{id}'  => 'OrderController@edit',
            '/encomenda/update'       => 'OrderController@update',
            '/encomenda/deletar/{id}' => 'OrderController@delete',
        ];
    }
}
