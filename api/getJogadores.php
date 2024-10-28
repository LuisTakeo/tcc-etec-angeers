<?php
    use function Connection\connect_to_db_pdo;
    use function controllers\jogadorController\getJogadores;

    header('Content-Type: application/json');

    include("../connection/connect.php");
    include("../controllers/jogadorController/jogadorController.php");

    try
    {
        $connect = connect_to_db_pdo($server, $user, $password, $db);
        if (!$connect)
        throw new \PDOException("Connection failed");
        $jogadores = getJogadores($connect);
        echo json_encode($jogadores);

    }
    catch (Exception $e)
    {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }


?>