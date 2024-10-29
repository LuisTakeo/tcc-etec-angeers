<?php

use function Connection\connect_to_db_pdo;
use controllers\usuarioController\UsuarioController;
// use repositories\UsuarioRepository;

// headers de permissão, cache e proteção contra ataques
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // Permite requisições de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeçalhos HTTP permitidos
header('Cache-Control: no-cache, no-store, must-revalidate'); // Controle de cache
header('X-Content-Type-Options: nosniff'); // Previne ataques de MIME type sniffing
header('X-Frame-Options: DENY'); // Protege contra ataques de clickjacking
header('X-XSS-Protection: 1; mode=block'); // Ativa a proteção contra ataques de XSS

include("../connection/connect.php");
include("../controllers/usuarioController/usuarioController.php");
include("../repository/UsuarioRepository.php");
include("../services/UsuarioService.php");
include("../model/Usuario.php");

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
    throw new \PDOException("Connection failed");
    $usuarioController = new UsuarioController($connect);
    $usuarioController->getClientes();
}
catch (Exception $e)
{
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}