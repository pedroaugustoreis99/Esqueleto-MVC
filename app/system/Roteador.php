<?php

namespace system;

use Error;

class Roteador
{
    /*
     * Usa as traits Rotas e Middlewares para reutilizar funcionalidades relacionadas a rotas e middlewares.
     */
    use Rotas, Middlewares;

    /*
     * Método principal para executar a lógica do roteamento.
     */
    public static function executar()
    {
        /*
         * Obtém o método HTTP da requisição (por exemplo, 'GET' ou 'POST').
         */
        $metodo_http = $_SERVER['REQUEST_METHOD'];

        /*
         * Obtém a rota acessada. Se não estiver definida, assume a rota raiz ('/').
         */
        $rota = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        /*
         * Obtém os parâmetros da URL (se houver).
         */
        $params = $_GET;

        /*
         * Verifica se a rota e o método HTTP existem no sistema.
         */
        if (self::rotaEMetodoExiste($metodo_http, $rota)) {

            /*
             * Executa os middlewares associados à rota.
             */
            self::executarMiddleware($rota);

            /*
             * Separa o nome do controlador e o método (action) a partir da rota definida.
             */
            list($controller, $action) = explode('@', self::$rotas[$metodo_http][$rota]);

            /*
             * 
             */
            try {
                $class = 'controllers\\' . $controller;
                $object = new $class();
                $object->$action(...$params);
            } catch(Error $e) {
                /*
                 * DEPOIS VOU IMPLEMENTAR UMA LÓGICA PARA SISTEMA DE LOGS
                 */
                echo "Ocorreu o seguinte erro: " . $e->getMessage();
            }

        } else {
            echo '<p>Vou criar uma view futuramente para informar que <mark>A rota acessada não existe!</mark></p>';
        }
    }
}