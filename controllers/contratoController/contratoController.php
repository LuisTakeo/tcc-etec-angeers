<?php
namespace controllers\contratoController;


function createContrato(\PDO $connect, int $usuario_id, int $jogador_id, int $servico_id, string $data_inicio, string $data_fim)
{
    $sql = "INSERT INTO tb_contrato (cd_cli, cd_jog, cd_serv, ds_statusjog, ds_statuscli, perc_jog, ds_data, ds_statuscontrato)
            VALUES (:usuario_id, :jogador_id, :servico_id, 'solicitado', 'aguardando resposta', 0.6, :data_inicio, 'pendente')";
    $state = $connect->prepare($sql);
    $state->bindParam(":usuario_id", $usuario_id);
    $state->bindParam(":jogador_id", $jogador_id);
    $state->bindParam(":servico_id", $servico_id);
    $state->bindParam(":data_inicio", $data_inicio);
    $state->execute();
    return $connect->lastInsertId();
}

function updateContratoStatus(\PDO $connect, int $contrato_id, string $status_usuario, string $status_jogador, string $motivo_recusa = null)
{
    $sql = "UPDATE tb_contrato SET ds_statuscli = :status_usuario, ds_statusjog = :status_jogador, ds_negou = :motivo_recusa WHERE cd_contrato = :contrato_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":status_usuario", $status_usuario);
    $state->bindParam(":status_jogador", $status_jogador);
    $state->bindParam(":motivo_recusa", $motivo_recusa);
    $state->bindParam(":contrato_id", $contrato_id);
    $state->execute();
}

function getContrato(\PDO $connect, int $id)
{
    $sql = "SELECT * FROM tb_contrato WHERE cd_contrato = :id";
    $state = $connect->prepare($sql);
    $state->bindParam(":id", $id);
    $state->execute();
    $result = $state->fetch(\PDO::FETCH_ASSOC);
    if (!$result)
        throw new \PDOException("Nenhum contrato encontrado");
    return $result;
}

function getContratosByUsuario(\PDO $connect, int $usuario_id)
{
    $sql = "SELECT * FROM tb_contrato WHERE cd_cli = :usuario_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":usuario_id", $usuario_id);
    $state->execute();
    return $state->fetchAll(\PDO::FETCH_ASSOC);
}

function getContratosByJogador(\PDO $connect, int $jogador_id)
{
    $sql = "SELECT * FROM tb_contrato WHERE cd_jog = :jogador_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":jogador_id", $jogador_id);
    $state->execute();
    return $state->fetchAll(\PDO::FETCH_ASSOC);
}

// Adicione outras funções conforme necessário, como deleteContrato, etc.
?>