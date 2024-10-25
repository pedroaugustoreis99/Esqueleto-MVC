<?php

function dd($data, $die = true) {
    echo '<div style="background-color: #333; color: #fff; padding: 10px; margin: 10px;">';
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    echo '</div>';
    if ($die) die;
}

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

function aes_encrypt($value) {
    return bin2hex(openssl_encrypt($value, 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV));
}

function aes_decrypt($value) {
    if (strlen($value) % 2 != 0) {
        return false;
    }
    return openssl_decrypt(hex2bin($value), 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV);
}