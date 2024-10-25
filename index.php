<?php

require_once "vendor/autoload.php";

session_start();

use system\Roteador;

Roteador::executar();