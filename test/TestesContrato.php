<?php

use models\Contrato;
use repository\ContratoRepository;
use services\ContratoService;
use controllers\contratoController\ContratoController;

use function connection\connect_to_db_pdo;

include_once '../connection/connect.php';
include_once '../model/Contrato.php';
include_once '../repository/ContratoRepository.php';
include_once '../services/ContratoService.php';
include_once '../controllers/contratoController/contratoController.php';


try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if ($connect == null)
    {
        throw new \PDOException("Erro ao conectar com o banco de dados");
    }
    $contrato = new Contrato(1, 1, 1, 1, "statusJogador", "statusCliente", "statusContrato", 100.00, .60, "2021-10-10", "avaliacao", 10, "motivoRecusa");
    var_dump($contrato);
    echo "<br>";
    $contratoRepository = new ContratoRepository($connect);
    var_dump($contratoRepository);
    echo "<br>";
    $contratoService = new ContratoService($contratoRepository);
    var_dump($contratoService);
    echo "<br>";
    $contratoController = new ContratoController($connect);
    var_dump($contratoController);
    echo "<br>";
    $contratoConsulta = $contratoController->getContratosByJogador(2);
    var_dump($contratoConsulta);
    echo "<br>";

    $contratoConsulta = $contratoController->getContratosByUsuario(3);
    var_dump($contratoConsulta);
    echo "<br>";

    echo "Consulta de contratos pendentes por usuario";
    $contratoConsulta = $contratoController->filterContratosPendentesByUsuario(3);
    var_dump($contratoConsulta);
    echo "<br>";

    $contratoConsulta = $contratoController->getContrato(1);
    var_dump($contratoConsulta);

    echo "<br>";

    $contratoConsulta = $contratoController->setContratoToAceito(1);
    $contratoConsulta = $contratoController->setContratoToFinalizado(1);
    $contratoConsulta = $contratoController->setAvaliacaoContrato(1, "Trampo muito bem feito", 10);

    var_dump($contratoConsulta);
    // $contratoConsulta = $contratoController->setContratoToRecusado(1, "Motivo de recusa");
    var_dump($contratoController->getContrato(1));

}
catch (\PDOException $err)
{
    echo $err->getMessage();
}
finally
{
    $connect = null;
}