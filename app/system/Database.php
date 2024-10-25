<?php

namespace system;

use PDO, PDOException, stdClass, DateTime;

class Database
{
    /*
     * Propriedades
     */
    private $_host, $_database, $_username, $_password, $_return_type;
    protected $erros = array();

    /*
     * Valores possíveis para configurar qual vai ser o formato de retorno dos métodos
     */
    public const int
        RETURN_OBJECT = PDO::FETCH_OBJ, // Retorna no formato de stdClass
        RETURN_ASSOC = PDO::FETCH_ASSOC; // Retorna no formato de array associativo

    /*
     * Essas constantes são utilizadas para informar se está criando ou atualizando um registro
     */
    const STATUS_CRIANDO = 1,
        STATUS_ATUALIZANDO = 2;

    public function __construct($cfg_options = MYSQL_CONFIG, $return_type = Database::RETURN_OBJECT)
    {
        /*
         * Definir as configurações da conexão
         */
        $this->_host = $cfg_options["host"];
        $this->_database = $cfg_options["database"];
        $this->_username = $cfg_options["username"];
        $this->_password = $cfg_options["password"];

        /*
         * Definir qual o tipo de dado vai ter o retorno
         */
        if (!empty($return_type) && $return_type == DATABASE::RETURN_OBJECT) {
            $this->_return_type = Database::RETURN_OBJECT;
        } else {
            $this->_return_type = Database::RETURN_ASSOC;
        }
    }

    /*
     * Executa uma consulta(query) com resultados
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
     * Método que vai ser utilizado como retorno dos métodos
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