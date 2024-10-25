<?php

namespace system;

trait Middlewares
{
    /*
     * Essa propriedade associa um nome de middleware a uma classe de middleware
     */
    protected static $middleware = [
        'apresentacao' => 'middlewares\apresentacaoMiddleware'
    ];

    /*
     * Essa propriedade associa uma rota específica a uma lista de middlewares que devem ser executados para aquela rota
     */
    protected static $rotaMiddleware = [
        '/' => [
            'apresentacao'
        ]
    ];

    /*
     * Executa os middlewares associados a uma rota específica
     */
    protected static function executarMiddleware($rota)
    {
        if (key_exists($rota, self::$rotaMiddleware)) {
            foreach (self::$rotaMiddleware[$rota] as $middleware) {
                $middlewareClass = self::$middleware[$middleware];
                $middlewareObject = new $middlewareClass();
                $middlewareObject->handle();
            }
        }
    }
}