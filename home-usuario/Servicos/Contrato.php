<?php
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadores;
use controllers\contratoController;
include("../../connection/connect.php");
include("../../controllers/jogadorController/jogadorController.php");
include("../../controllers/contratoController/contratoController.php");

include_once("../../connection/session_secure.php");
$connect = connect_to_db_pdo($server, $user, $password, $db);
if (!isset($_SESSION['user_id']))
{
    echo "<h1>Usuário não logado</h1>";
}

$test = contratoController\createContrato($connect, $_SESSION['user_id'], 1, 1, date("Y-m-d"), date("Y-m-d", strtotime("+1 month")));

if ($test) {
    echo "<h1>Contrato criado com sucesso!</h1>";
} else {
    echo "<h1>Erro ao criar contrato!</h1>";
}