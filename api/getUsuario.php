<?php
    use function Connection\connect_to_db_pdo;
    use function controllers\usuarioController\getClienteByEmail;

    header('Content-Type: application/json');

    include("../connection/connect.php");
    include("../controllers/usuarioController/usuarioController.php");

    try
    {
        // conexão com o banco de dados
        $connect = connect_to_db_pdo($server, $user, $password, $db);
        if (!$connect)
            throw new \PDOException("Connection failed");
        // filtragem dos dados de entrada
        $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_GET, 'senha', FILTER_UNSAFE_RAW);
        // busca do jogador
        $cliente = getClienteByEmail($connect, $email);
        if (!$cliente)
            throw new \Exception("Cliente não encontrado");
        // verificação da senha
        if (!password_verify($senha, $cliente['ds_senha']))
            throw new \Exception("Senha incorreta");
        $clienteApi = [
            'id_cliente' => $cliente['cd_cli'],
            'nome' => $cliente['name_cli'],
            'email' => $cliente['ds_email'],
            'senha' => $cliente['ds_senha'],
            'cpf' => $cliente['no_cpf'],
            'statusCode' => "Ok"
        ];
        http_response_code(200);
        echo json_encode($clienteApi);
    }
    catch (\PDOException $e)
    {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage(), 'statusCode' => 500]);
    }
    catch (Exception $e)
    {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage(), 'statusCode' => "Bad Request"]);
    }