<?php

namespace helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    /*
     * Método privado que inicializa o logger e configura o handler.
     * Esse método cria uma instância do Logger e adiciona um StreamHandler, que define o arquivo onde os logs serão salvos.
     * 
     * @return Logger - Retorna a instância configurada do logger.
     */
    private static function getLogger()
    {
        $log = new Logger('app_logs');
        $log->pushHandler(new StreamHandler('app/logs/app.log'));
        return $log;
    }

    /*
     * Registra uma mensagem de log de nível 'info'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function info($msg)
    {
        self::getLogger()->info($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'notice'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function notice($msg)
    {
        self::getLogger()->notice($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'warning'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function warning($msg)
    {
        self::getLogger()->warning($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'error'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function error($msg)
    {
        self::getLogger()->error($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'critical'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function critical($msg)
    {
        self::getLogger()->critical($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'alert'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function alert($msg)
    {
        self::getLogger()->alert($msg);
    }

    /*
     * Registra uma mensagem de log de nível 'emergency'.
     * @param string $msg - A mensagem a ser registrada.
     */
    public static function emergency($msg)
    {
        self::getLogger()->emergency($msg);
    }
}