<?php
use function Connection\connect_to_db_pdo;
use function controllers\contratoController\getContratosByUsuario;

function showStatus(string $status): string
{
    switch ($status) {
        case 'buscando':
            return "Buscando jogadores";
        case 'solicitado':
            return "Aguardando resposta";
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

include_once("../connection/connect.php");
include_once("../controllers/contratoController/contratoController.php");

function showContratosPendentes(array $contratos)
{
    echo "<section class='main__servicos'>
        <div class='main__servicos__title'>
                <h3>Serviços Pendentes</h3>
        </div>
        <div class='main__servicos__cards'>";
        foreach ($contratos as $contrato)
        {
            if ($contrato['ds_statuscontrato'] != 'pendente') {
                continue;
            }
            echo "<div class='card'>";
            echo "<div class='card__description'>";
            echo "<h4 class='card__description__title'>" .
                ($contrato['cd_jog'] ? $contrato['name_jog'] : "Aguardando jogador") ."</h4>";
            echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscli']) . "</p>";
            echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
            echo "<p class='card_description_text'>Inicio-" .
            DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  .
            " </p>";
            echo "<a class='card__link' href='#'>Detalhes</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>
            </section>";
}

function showContratosAtivos(array $contratos)
{

    echo "<section class='main__servicos'>
        <div class='main__servicos__title'>
                <h3>Serviços Ativos</h3>
        </div>";

        $contratos_ativos = array_filter($contratos, function($contrato) {
            return $contrato['ds_statuscontrato'] == 'ativo';
        });
        if (empty($contratos_ativos))
        echo "<h3>Nenhum contrato ativo!</h3>";
        else
        {
            echo "<div class='main__servicos__cards'>";
            foreach ($contratos_ativos as $contrato)
            {
                echo "<div class='card'>";
                echo "<div class='card__description'>";
                echo "<h4 class='card__description__title'>" .
                    ($contrato['cd_jog'] ? $contrato['name_jog'] : "Aguardando jogador") ."</h4>";
                echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscontrato']) . "</p>";
                echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
                echo "<p class='card_description_text'>Inicio-" .
                DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  .
                " </p>";
                echo "<a class='card__link' href='#'>Detalhes</a>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        // var_dump($contratos);
        echo "</section>";
}
function showContratosFinalizados(array $contratos)
{

    echo "<section class='main__servicos'>
        <div class='main__servicos__title'>
                <h3>Serviços Finalizados</h3>
        </div>";
        $contratos_finalizados = array_filter($contratos, function($contrato) {
            return $contrato['ds_statuscontrato'] == 'finalizado';
        });
        if (empty($contratos_finalizados))
            echo "<h3>Nenhum contrato finalizado!</h3>";
        else
        {
            echo "<div class='main__servicos__cards'>";
            foreach ($contratos_finalizados as $contrato)
            {
                echo "<div class='card'>";
                echo "<div class='card__description'>";
                echo "<h4 class='card__description__title'>" .
                    ($contrato['cd_jog'] ? $contrato['name_jog'] : "Aguardando jogador") ."</h4>";
                echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscontrato']) . "</p>";
                echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
                echo "<p class='card_description_text'>Inicio-" .
                DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  .
                " </p>";
                echo "<a class='card__link' href='#'>Detalhes</a>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        // var_dump($contratos);
        echo "</section>";
}

try {
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    $contratos = getContratosByUsuario($connect, $_SESSION['user_id']);
    // var_dump($contratos);

    if ($contratos)
    {
        showContratosPendentes($contratos);
        showContratosAtivos($contratos);
        showContratosFinalizados($contratos);
    } else {
        echo "<h1>Nenhum contrato encontrado!</h1>";
    }
    $connect = null;
} catch (Exception $e) {
    echo "<h1>Erro ao buscar contratos!</h1>";
}

?>

<!-- echo "<div class='main__servicos__cards'>
        <div class='card'>
            <div class='card__description'>
                <h4 class='card__description__title'>Jogador Prof A</h4>
                <p class='card__description__text'>Duo Boost - Em andamento</p>
                <img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>
                <p class='card_description_text'>Inicio-01/09/2024 </p>
                <a class='card__link' href='#'>Detalhes</a>
            </div>

        </div>
        <div class='card'>
            <div class='card__description'>
                <h4 class='card__description__title'>Jogador Prof B</h4>
                <p class='card__description__text'>Coach - Em andamento </p>
                <img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>
                <p class='card_description_text'>Inicio-09/09/2024 </p>
                <a class='card__link' href='#'>Detalhes</a>
            </div>

        </div>
        <div class='card center'>
            <a href='./Servicos/Servicos.html' class='card__add__service'>
                <img width='50' height='50' src='https://img.icons8.com/ios/50/add--v1.png' alt='add--v1'/>
                <p class='service_text'>Adicionar</p>
            </a>
        </div>

    </div>
    <div class='main__servicos__title'>
        <h3>Finalizado</h3>
    </div>
    <div class='main__servicos__cards'>
        <div class='card'>
            <div class='card__description'>
                <h4 class='card__description__title'>Jogador Prof A</h4>
                <p class='card__description__text'>Duo Boost - Em andamento</p>
            </div>
            <a class='card__link' href='#'>Delhes</a>
        </div>
        <div class='card'>
            <div class='card__description'>
                <h4 class='card__description__title'>Jogador Prof B</h4>
                <p class='card__description__text'>Coach - Finalizado</p>
            </div>
            <a class='card__link' href='#'>Detalhes</a>
        </div>
    </div>
</section>"; -->
