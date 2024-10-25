<?php

/*
 * Define o nome da aplicação.
 */
define('NOME_APP', 'Esqueleto MVC');

/*
 * Configurações do banco de dados que será utilizado na aplicação
 * Essa constante será usada na classe system\Database para conectar ao banco de dados.
 */
define('MYSQL_CONFIG', [
    'host' => '', // Endereço do host (ex: 'localhost' ou IP do servidor).
    'database' => '', // Nome do banco de dados a ser utilizado.
    'username' => '', // Nome do usuário para acessar o banco.
    'password' => '' // Senha do usuário do banco de dados
]);

/*
 * Constantes utilizadas para criptografar e descriptografar dados
 * Serão usadas em app/helpers/functions para garantir a segurança dos dados
 */
define('OPENSSL_KEY', ''); // Chave utilizada pelo OpenSSL para criptografia e descriptografia
define('OPENSSL_IV', ''); // Vetor de inicialização (IV) para a criptografia OpenSSL