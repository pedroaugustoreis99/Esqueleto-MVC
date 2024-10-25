<?php

namespace system;

use PDO, PDOException, stdClass, DateTime;

class Database
{
    /*
     * Propriedades privadas para armazenar as configurações de conexão e o tipo de retorno padrão.
     */
    private $_host, $_database, $_username, $_password, $_return_type;
    protected $erros = array();

    /*
     * Constantes que definem os tipos de retorno possíeis para as consultas.
     */
    public const int
        RETURN_OBJECT = PDO::FETCH_OBJ, // Retorna no formato de stdClass
        RETURN_ASSOC = PDO::FETCH_ASSOC; // Retorna no formato de array associativo

    /*
     * Constantes que indicam o status da operação: criando ou atualizando um registro.
     */
    const STATUS_CRIANDO = 1,
        STATUS_ATUALIZANDO = 2;

    /*
     * Construtor da classe Database
     * @param array $cfg_options - Configurações para a conexão (como host, database, username e password).
     * @param int $return_type - Define o tipo de retorno padrão (object ou array associativo).
     */
    public function __construct($cfg_options = MYSQL_CONFIG, $return_type = Database::RETURN_OBJECT)
    {
        /*
         * Definir as configurações da conexão.
         */
        $this->_host = $cfg_options["host"];
        $this->_database = $cfg_options["database"];
        $this->_username = $cfg_options["username"];
        $this->_password = $cfg_options["password"];

        /*
         * Definir qual o tipo de dado vai ter o retorno.
         */
        if (!empty($return_type) && $return_type == DATABASE::RETURN_OBJECT) {
            $this->_return_type = Database::RETURN_OBJECT;
        } else {
            $this->_return_type = Database::RETURN_ASSOC;
        }
    }

    /*
     * Executa uma consulta (query) com resultados.
     * @param string $sql - A consulta SQL a ser executada.
     * @param array|null @params - Parâmetros a serem passados para a consulta (para consultas preparadas).
     * @return object - Retorna um objeto com informações sobre o status da operação e resultados.
     */
    public function execute_query($sql, $params = null)
    {
        try {
            $conn = new PDO(
                'mysql:host=' . $this->_host . ';dbname=' . $this->_database,
                $this->_username,
                $this->_password,
                array(PDO::ATTR_PERSISTENT => true)
            );

            $results = null;

            $pr = $conn->prepare($sql);
            if (!empty($params)) {
                $pr->execute($params);
            } else {
                $pr->execute();
            }

            $results = $pr->fetchAll($this->_return_type);
            $conn = null;
            return $this->_result("success", null, $sql, $results, $pr->rowCount(), null);
        } catch (PDOException $error) {
            return $this->_result('error', $error->getMessage(), $sql, null, 0, null);
        }
    }

    /*
     * Executa uma consulta que não retorna resultados (INSERT, UPDATE, DELETE, ...).
     * @param string $sql - A consulta SQL a ser executada.
     * @params array|null $params - Parâmetros a serem passados para a consulta (para consultas preparadas).
     * @return object - Retorna um objeto com informações sobre o status da operação e o ID inserido (se aplicável).
     */
    public function execute_non_query($sql, $params = null)
    {
        try {
            $conn = new PDO(
                'mysql:host=' . $this->_host . ';dbname=' . $this->_database,
                $this->_username,
                $this->_password,
                array(PDO::ATTR_PERSISTENT => true)
            );

            $pr = $conn->prepare($sql);
            if (!empty($params)) {
                $pr->execute($params);
            } else {
                $pr->execute();
            }

            $last_inserted_id = $conn->lastInsertId();
            $conn = null;
            return $this->_result("success", null, $sql, null, $pr->rowCount(), $last_inserted_id);
        } catch (PDOException $error) {
            return $this->_result('error', $error->getMessage(), $sql, null, 0, null);
        }
    }

    /*
     * Método privado para padronizar o retorno dos métodos de execução de consultas.
     * @param string $status - Status da operação ('success' ou 'error').
     * @param string|null $msg - Mensagem de erro, se houver.
     * @param string $sql - A consulta SQL executada.
     * @param array|object|null $results - Os resultados da consulta, se houver.
     * @param int $affected_rows - Número de linhas afetadas pela consulta.
     * @param int|null $last_id - ID do último registro inserido, se aplicável.
     * @return object - Retorna um objeto com todas as informações da operação.
     */
    private function _result($status, $msg, $sql, $results, $affected_rows, $last_id)
    {
        $stdObj = new stdClass();
        $stdObj->status = $status;
        $stdObj->msg = $msg;
        $stdObj->sql = $sql;
        $stdObj->results = $results;
        $stdObj->affected_rows = $affected_rows;
        $stdObj->last_id = $last_id;
        return $stdObj;
    }
}