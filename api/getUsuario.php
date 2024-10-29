<?php

    use controllers\usuarioController\UsuarioController;
    use function Connection\connect_to_db_pdo;
    use function controllers\usuarioController\getClienteByEmail;

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
        // conexão com o banco de dados
        $connect = connect_to_db_pdo($server, $user, $password, $db);
        if (!$connect)
            throw new \PDOException("Connection failed");

        // filtragem dos dados de entrada
        $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_GET, 'senha', FILTER_UNSAFE_RAW);
        if (!$email || !$senha) {
            throw new Exception("Dados de entrada inválidos");
        }
        $usuarioController = new UsuarioController($connect);
        $usuarioController->loginToApi($email, $senha);
    }
    catch (\PDOException $e)
    {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage(), 'statusCode' => "Failed"], JSON_UNESCAPED_UNICODE);
    }
    catch (Exception $e)
    {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage(), 'statusCode' => "Bad Request"], JSON_UNESCAPED_UNICODE);
    }
    finally
    {
        $connect = null;
    }