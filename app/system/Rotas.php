<?php

namespace system;

trait Rotas
{
    /*
     * Essa propriedade armazena as rotas existentes na aplicação.
     * As rotas estão organizadas por métodos HTTP ('GET', 'POST')
     * O array associativo mapeia cada rota para um controlador e uma ação específica
     */
    protected static $rotas = [
        'GET' => [
            '/' => 'MainController@index'
        ],
        'POST' => [

        ]
    ];

    /*
     * Verifica se um método HTTP e uma rota específica existem no array de rotas
     * Retorna true se o método e a rota existem, caso contrário retorna false
     */
    protected static function rotaEMetodoExiste($metodo, $rota)
    {
        if (key_exists($metodo, self::$rotas) AND key_exists($rota, self::$rotas[$metodo])) {
            return true;
        } else {
            return false;
        }
    }
}