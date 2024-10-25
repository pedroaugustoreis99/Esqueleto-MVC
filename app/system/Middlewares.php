<?php

namespace system;

trait Middlewares
{
    /*
     * Essa propriedade associa um nome de middleware a uma classe de middleware.
     * O array mapeia nomes de middlewares para as classes que os implementam.
     */
    protected static $middleware = [
        'apresentacao' => 'middlewares\\apresentacaoMiddleware' // Mapeia o nome 'apresentacao' para a classe 'apresentacaoMiddleware'.
    ];

    /*
     * Essa propriedade associa uma rota específica a uma lista de middlewares que devem ser executados para aquela rota.
     * Cada rota pode ter um ou mais middlewares definidos.
     */
    protected static $rotaMiddleware = [
        '/' => [
            'apresentacao' // Middleware 'apresentacao' será executado para a rota '/'.
        ]
    ];

    /*
     * Executa os middlewares associados a uma rota específica.
     * @param string $rota - A rota para a qual os middlewares devem ser executados.
     */
    protected static function executarMiddleware($rota)
    {
        /*
         * Verifica se existem middlewares associados à rota especificada
         */
        if (key_exists($rota, self::$rotaMiddleware)) {
            /*
             * Percorre todos os middlewares associados à rota
             */
            foreach (self::$rotaMiddleware[$rota] as $middleware) {
                /*
                 * Executa o método handle() do middleware.
                 */
                $middlewareClass = self::$middleware[$middleware];
                $middlewareObject = new $middlewareClass();
                $middlewareObject->handle();
            }
        }
    }
}