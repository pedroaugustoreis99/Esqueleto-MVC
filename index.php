<?php

/*
 * Carrega automaticamente todas as classes e arquivos necessárias usando o autoloader do Composer.
 */
require_once "vendor/autoload.php";

session_start();

use system\Roteador;

/*
 * Executa o roteador, que é responsável por gerenciar as rotas e controlar o fluxo da aplicação.
 */
Roteador::executar();