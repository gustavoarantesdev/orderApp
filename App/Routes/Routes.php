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
            '/'                  => 'LoginController@index',
            '/login'             => 'LoginController@login',
            '/login/create'      => 'LoginController@create',
            '/login/store'       => 'LoginController@store',
            '/logout'            => 'LoginController@logout',

            '/order/home'        => 'OrderController@index',
            '/order/create'      => 'OrderController@create',
            '/order/store'       => 'OrderController@store',
            '/order/show'        => 'OrderController@show',
            '/order/edit/{id}'   => 'OrderController@edit',
            '/order/update'      => 'OrderController@update',
            '/order/delete/{id}' => 'OrderController@delete',
        ];
    }
}
