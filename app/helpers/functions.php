<?php

/*
 * Função de depuração que exibe dados formatados e encerra a execução, se necessário.
 * @param mixed $data - Os dados a serem exibidos (pode ser qualquer tipo).
 * @param bool $die - Se verdadeiro, encerra a execução após exibir os dados (padrão: true).
 */
function dd($data, $die = true) {
    echo '<div style="background-color: #333; color: #fff; padding: 10px; margin: 10px;">';
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    echo '</div>';
    if ($die) die;
}

/*
 * Função para carregar uma view com os dados fornecidos.
 * @param string $view - O nome da view a ser carregada (ex: 'home' para 'app/views/home.php' ou 'clientes/index' para 'app/views/clientes/index.php')
 * @param array $data - Dados a serem extraídos e passados para a view.
 */
function view($view, $data = [])
{
    if (!is_array($data)) die('$data deve ser um Array');

    extract($data);

    if (file_exists('app/views/' . $view . '.php')) {
        require_once 'app/views/' . $view . '.php';
    } else {
        die('A view ' . $view . ' não existe!');
    }
}

/*
 * Função para criptografar um valor usando AES-256-CBC.
 * @param string $value - O valor a ser criptografado.
 * @return string - Retorna o valor criptografado em formato hexadecimal.
 */
function aes_encrypt($value) {
    return bin2hex(openssl_encrypt($value, 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV));
}

/*
 * Função para descriptografar um valor usando AES-256-CBC.
 * @param string $value - O valor criptografado em formato hexadecimal.
 * @return string|false - Retorna o valor descriptografado ou false se a operação falhar.
 */
function aes_decrypt($value) {
    if (strlen($value) % 2 != 0) {
        return false;
    }
    return openssl_decrypt(hex2bin($value), 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV);
}