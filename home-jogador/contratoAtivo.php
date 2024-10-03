<?php
use function Connection\connect_to_db_pdo;
use function controllers\contratoController\getContratosByJogador;
use function controllers\contratoController\getContratosPendentes;
use function controllers\contratoController\updateContratoStatus;
use function controllers\contratoController\updateContratoStatusPendente;

include_once("../connection/connect.php");
include_once("../controllers/contratoController/contratoController.php");
include_once("../connection/session_secure.php");

if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: ../login/login.php');
    exit();
}
if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "usuario") {
    header("Location: ../home-usuario/home.php");
    exit();
}

$is_pendente = filter_input(INPUT_GET, 'pendente', FILTER_VALIDATE_BOOLEAN);

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if ($is_pendente)
    {
        echo "Entrou agui";
        updateContratoStatusPendente($connect, $_GET['contrato_id'], $_SESSION['user_id'], 'aceito', 'aceito', 'ativo', NULL);
    } else
        updateContratoStatus($connect, $_GET['contrato_id'], 'aceito', 'aceito', 'ativo');
    echo "Contrato aceito com sucesso!";
    header("Location: ./home.php");

    } catch (\PDOException $e)
{
    echo "Erro ao conectar com o banco de dados. Erro: " . $e->getMessage();
    exit();
}