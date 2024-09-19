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
    public static function getRoutes()
    {
        return [
            '/'            => 'OrderController@index',
            '/create'      => 'OrderController@create',
            '/store'       => 'OrderController@store',
            '/show'        => 'OrderController@show',
            '/edit/{id}'   => 'OrderController@edit',
            '/update/{id}' => 'OrderController@update',
            '/delete/{id}' => 'OrderController@delete',
        ];
    }
}
