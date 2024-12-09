<?php

require 'vendor/autoload.php';

// Carrega as variáveis do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__));
$env = $dotenv->load();

// Define constants for environment variables
define('MERCADO_PAGO_ACCESS_TOKEN', $_ENV['MERCADO_PAGO_ACCESS_TOKEN']);
define('MERCADO_PAGO_PUBLIC_KEY', $_ENV['MERCADO_PAGO_PUBLIC_KEY']);

// BD
define('DB_SERVER', $_ENV['SERVER']);
define('DB_USER', $_ENV['USER']);
define('DB_PASSWORD', $_ENV['PASSWORD']);
define('DB_NAME', $_ENV['DATABASE']);


// var_dump($_ENV);