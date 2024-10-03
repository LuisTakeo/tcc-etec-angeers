<?php
use function Connection\connect_to_db_pdo;
use function controllers\contratoController\getContratosByJogador;
use function controllers\contratoController\getContratosPendentes;


include_once("../connection/connect.php");
include_once("../controllers/contratoController/contratoController.php");
include_once("../connection/session_secure.php");

// FUNCTIONS VIEW

function showStatus(string $status): string
{
    switch ($status) {
        case 'buscando':
            return "Buscando jogadores";
        case 'solicitado':
            return "Aguardando sua resposta";
        case 'recusado':
            return "Recusado";
        case 'aceito':
            return "Aceito";
        case 'ativo':
            return "Ativo";
        default:
            return "Desconhecido";
    }
}

function showContratosPendentes(array $contratos)
{
        echo "<section class='main__servicos'>
            <div class='main__servicos__title'>
                    <h3>Serviços Pendentes</h3>
            </div>
            <div class='main__servicos__cards'>";
        $contratos_pendentes = array_filter($contratos, function($contrato) {
            return $contrato['ds_statuscontrato'] == 'pendente';
        });
        foreach ($contratos_pendentes as $contrato)
        {
            if ($contrato['ds_statuscli'] != 'buscando')
            {
                continue;
            }
            // var_dump($contrato);
            echo "<div class='card'>";
            echo "<div class='card__description'>";
            echo "<h4 class='card__description__title'>" .
                ($contrato['cd_cli'] ? $contrato['name_cli'] : "Aguardando jogador") ."</h4>";
            echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscli']) . "</p>";
            echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
            echo "<p class='card_description_text'>Inicio-" .
            DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  .
            " </p>";
            // echo "<a class='card__link' href='#'>Detalhes</a>";
            echo "<a class='card__link' href='./contratoAtivo.php?pendente=1&contrato_id=".$contrato['cd_contrato']."'>Aceitar</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>
            </section>";
}

function showContratosSolicitadoCliente(array $contratos)
{
    echo "<section class='main__servicos'>
    <div class='main__servicos__title'>
            <h3>Solicitações</h3>
    </div>
    <div class='main__servicos__cards'>";
    $contratos_solicitados = array_filter($contratos, function($contrato) {
        return $contrato['ds_statusjog'] == 'aguardando';
    });
    foreach ($contratos_solicitados as $contrato)
    {
        echo "<div class='card'>";
        echo "<div class='card__description'>";
        echo "<h4 class='card__description__title'>" .
            ($contrato['cd_jog'] ? $contrato['name_jog'] : "Aguardando jogador") ."</h4>";
        echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscli']) . "</p>";
        echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
        echo "<p class='card_description_text'>Inicio-" . DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  . " </p>";
        echo "<a class='card__link' href='./contratoAtivo.php?pendente=0&contrato_id=".$contrato['cd_contrato']."'>Aceitar</a>";
    }
    echo "</div>
        </section>";
}

function showContratosAtivos(array $contratos)
{
    echo "<section class='main__servicos'>
    <div class='main__servicos__title'>
            <h3>Serviços ativos</h3>
    </div>
    <div class='main__servicos__cards'>";
    $contratos_ativos = array_filter($contratos, function($contrato) {
        return $contrato['ds_statuscontrato'] == 'ativo';
    });
    foreach ($contratos_ativos as $contrato)
    {
        echo "<div class='card'>";
        echo "<div class='card__description'>";
        echo "<h4 class='card__description__title'>" .
            ($contrato['cd_cli'] ? $contrato['name_cli'] : "Aguardando jogador") ."</h4>";
        echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscontrato']) . "</p>";
        echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
        echo "<p class='card_description_text'>Inicio-" . DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  . " </p>";
        echo "<a class='card__link' href='#'>Detalhes</a>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>
        </section>";
}
// MAIN


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
    $contratosdoJogador = getContratosByJogador($connect, $_SESSION['user_id']);
    $contratosPendentes = getContratosPendentes($connect);
    // var_dump($contratosdoJogador);
    // var_dump($contratosPendentes);

    if ($contratosdoJogador)
    {
        showContratosSolicitadoCliente($contratosdoJogador);
        showContratosPendentes($contratosPendentes);
        showContratosAtivos($contratosdoJogador);
        // showContratosFinalizados($contratos);
    } else {
        echo "<h1>Nenhum contrato encontrado!</h1>";
    }
    $connect = null;
} catch (Exception $e) {
    echo "<h1>Erro ao buscar contratos!</h1>";
}
?>