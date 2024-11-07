<?php
use function Connection\connect_to_db_pdo;
use function controllers\contratoController\createContrato;
use function controllers\contratoController\createContratoPendente;
use function controllers\jogadorController\getJogadores;
use function PHPSTORM_META\type;

use controllers\contratoController;
include("../../connection/connect.php");
include("../../controllers/jogadorController/jogadorController.php");
include("../../controllers/contratoController/contratoController.php");
include_once("../../connection/session_secure.php");
if (!isset($_SESSION['user_id'])) {
	// Se não estiver logado, redireciona para a página de login
	header('Location: ../../login/login.php');
	exit();
}
if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "jogador") {
	header("Location: ../../home-jogador/home.php");
	exit();
}

// echo $_GET['tipo'];
// echo $_GET['idServico'];
$tipo_servico = filter_input(INPUT_GET, 'tipo', FILTER_UNSAFE_RAW);
echo $tipo_servico;
echo "<br>";
$id_servico = filter_input(INPUT_GET, 'idServico', FILTER_UNSAFE_RAW);
$escolher_jogador = filter_input(INPUT_GET, 'escolherJogador', FILTER_VALIDATE_INT);
$id_jogador = filter_input(INPUT_GET, 'idJogador', FILTER_VALIDATE_INT);
echo $id_servico;
var_dump($escolher_jogador);
var_dump($id_jogador);
var_dump($_SESSION);

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    // $test = contratoController\createContrato($connect, $_SESSION['user_id'], 1, 1, date("Y-m-d"), date("Y-m-d", strtotime("+1 month")));
    echo "<br>";
    echo "<br>";
    if (!$escolher_jogador)
        $idContrato = createContratoPendente($connect, $_SESSION['user_id'], $id_servico, date("Y-m-d"), 20.00);
    else
        $idContrato = createContrato($connect, $_SESSION['user_id'], $id_jogador, $id_servico, date("Y-m-d"), 20.00);
    echo "Criado com sucesso: " . $idContrato;
    header("Location: ../../home-usuario/home.php");
    // if ($test) {
    //     echo "<h1>Contrato criado com sucesso!</h1>";
    // } else {
    //     echo "<h1>Erro ao criar contrato!</h1>";
    // }
    $connect = null;
} catch (Exception $e) {
    echo $e->getMessage();
}
?>