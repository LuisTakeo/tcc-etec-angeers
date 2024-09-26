<?php
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadores;
use controllers\contratoController;
include("../../connection/connect.php");
include("../../controllers/jogadorController/jogadorController.php");
include("../../controllers/contratoController/contratoController.php");

include_once("../../connection/session_secure.php");
if (!isset($_SESSION['user_id']))
{
    echo "<h1>Usuário não logado</h1>";
}
try

{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    // $test = contratoController\createContrato($connect, $_SESSION['user_id'], 1, 1, date("Y-m-d"), date("Y-m-d", strtotime("+1 month")));
    $test = contratoController\getContratosByJogador($connect, 1);
    var_dump($test);
    if ($test)
    {
        echo "<h1>Contratos encontrados!</h1>";
        foreach ($test as $contrato)
        {
            echo "<h2>Contrato: " . $contrato['cd_contrato'] . "</h2>";
            echo "<p>Jogador: " . $contrato['name_jog'] . "</p>";
            echo "<p>Serviço: " . $contrato['cd_serv'] . "</p>";
            echo "<p>Status do jogador: " . $contrato['ds_statusjog'] . "</p>";

        }
    }
    else
    {
        echo "<h1>Nenhum contrato encontrado!</h1>";
    }


    // if ($test) {
    //     echo "<h1>Contrato criado com sucesso!</h1>";
    // } else {
    //     echo "<h1>Erro ao criar contrato!</h1>";
    // }
    $connect = null;
} catch (Exception $e)
{
    echo $e->getMessage();
}