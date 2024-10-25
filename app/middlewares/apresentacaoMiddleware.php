<?php

namespace middlewares;

class apresentacaoMiddleware
{
    public function handle()
    {
        echo "
            <div style='background-color: rgba(100,149,237,0.25); border-radius: 18px; padding: 5px; border: 2px solid rgba(100,149,237);text-align: center'>
                Esse quadro foi criado pelo <span style='font-weight: bolder; color: rgb(61,90,145)'>" . __METHOD__ . "</span>
                <p>Versão do PHP: " . phpversion() . "</p>
            </div>
        ";
    }
}