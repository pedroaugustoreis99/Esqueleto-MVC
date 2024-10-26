<?php

namespace system;

use Error;
use helpers\Log;

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
             * Cria uma instância do controlador e chama o método (action) passando os parâmetros da requisição
             */
            try {
                $class = 'controllers\\' . $controller;
                $object = new $class();
                $object->$action(...$params);
            } catch(Error $e) {
                /*
                 * O erro será registrado no sistema de Logs.
                 */
                Log::critical("Ocorreu um erro na action " . __METHOD__ . ". Mensagem do erro: " . $e->getMessage());

                /*
                 * Essa view informa que ocorreu um problema interno no sistema!
                 * Ela tem um link que retorna para à página principal.
                 */
                view('sistema/erro-interno');
            }

        } else {
            /*
             * Essa view informa ao usuário que a página não existe!
             * Ela tem um link que retorna para à página principal.
             */
            view('sistema/pagina-nao-encontrada');
        }
    }
}