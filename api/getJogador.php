<?php
    use function Connection\connect_to_db_pdo;
    use function controllers\jogadorController\getJogadorByEmail;

    // header('Content-Type: application/json');

    include("../connection/connect.php");
    include("../controllers/jogadorController/jogadorController.php");

    try
    {
        // conexão com o banco de dados
        $connect = connect_to_db_pdo($server, $user, $password, $db);
        if (!$connect)
            throw new \PDOException("Connection failed");
        // filtragem dos dados de entrada
        $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_GET, 'senha', FILTER_UNSAFE_RAW);
        if ($email == null || $senha == null)
            throw new \Exception("Email ou senha não informados");
        // busca do jogador
        $jogador = getJogadorByEmail($connect, $email);
        if (!$jogador)
            throw new \Exception("Jogador não encontrado");
        // verificação da senha
        if (!password_verify($senha, $jogador['ds_senha']))
            throw new \Exception("Senha incorreta");
        $jogadorApi = [
            'id_jogador' => $jogador['cd_jog'],
            'nome' => $jogador['name_jog'],
            'email' => $jogador['ds_email'],
            'senha' => $jogador['ds_senha'],
            'cpf' => $jogador['no_cpf'],
            'rank' => $jogador['ds_rank'],
            'statusCode' => 200
        ];
        http_response_code(200);
        echo json_encode($jogadorApi);

    }
    catch (\PDOException $e)
    {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage(), 'statusCode' => 500]);
    }

    ?>