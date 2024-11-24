<?php

use function Connection\connect_to_db_pdo;
use controllers\contratoController\ContratoController;

include_once("./includes.php");

if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: ../login/login.php');
    exit();
}
if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "usuario") {
    header("Location: ../home-usuario/home.php");
    exit();
}

try {
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
        throw new \PDOException("Connection failed");
    $id = filter_input(INPUT_GET, 'idContrato', FILTER_SANITIZE_NUMBER_INT);
    $contratoController = new ContratoController($connect);
    $contrato = $contratoController->getContrato($id);
    echo $contratoController->setContratoToFinalizado($id);
    header("Location: ./home.php");
} catch (\PDOException $e) {
    echo $e->getMessage();
    exit();
}