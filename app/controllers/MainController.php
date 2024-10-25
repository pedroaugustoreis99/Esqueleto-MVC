<?php

namespace controllers;

use helpers\Log;

class MainController
{
    public function index()
    {
        /*
         * O Esqueleto-MVC já vem com a classe Log implementada para registrar logs na aplicação!
         * Essa classe fica armazenada em app/helpers/Log.php
         * Os criados por essa classe ficam armazenados em app/logs/app.log
         */
        Log::info('A action ' . __METHOD__ . ' foi acessada!');

        echo 'Aqui eu vou deixar uma pequena documentação da aplicação';
    }
}