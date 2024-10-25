<?php

namespace system;

use Error;
class Roteador
{
    use Rotas, Middlewares;
    public static function executar()
    {
        $metodo_http = $_SERVER['REQUEST_METHOD'];
        $rota = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $params = $_GET;

        if (self::rotaEMetodoExiste($metodo_http, $rota)) {
            self::executarMiddleware($rota);

            list($controller, $action) = explode('@', self::$rotas[$metodo_http][$rota]);

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