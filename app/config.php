<?php

define('NOME_APP', 'Esqueleto MVC');

/*
 * Configurações do banco de dados que será utilizado na aplicação
 * Essa constante vai ser utilizada em system\Database
 */
define('MYSQL_CONFIG', [
    'host' => '',
    'database' => '',
    'username' => '',
    'password' => ''
]);

/*
 * Constantes utilizadas para criptografar e descriptografar dados
 * Vão ser utilizadas em app/helpers/functions
 */
define('OPENSSL_KEY', '');
define('OPENSSL_IV', '');