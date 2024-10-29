<?php
namespace repository;

use models\Contrato;

class ContratoRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    public function commit()
    {
        $this->db->commit();
    }

    public function rollBack()
    {
        $this->db->rollBack();
    }

    function createContrato(Contrato $newContrato)
    {
        $sql = "INSERT INTO tb_contrato (cd_cli, cd_jog, cd_serv, ds_statusjog, ds_statuscli, perc_jog, ds_data, ds_statuscontrato, vl_valor)
            VALUES (:usuario_id, :jogador_id, :servico_id, :status_jogador, :status_cliente, :percentual, :data_inicio, :status_contrato, :valor)";

        $state = $this->db->prepare($sql);
        $arrayContrato = $newContrato->toArray();
        $state->bindParam(":usuario_id", $arrayContrato["idCliente"]);
        $state->bindParam(":jogador_id", $arrayContrato["idJogador"]);
        $state->bindParam(":servico_id", $arrayContrato["idServico"]);
        $state->bindParam(":data_inicio", $arrayContrato["dataInicio"]);
        $state->bindParam(":valor", $arrayContrato["valor"]);
        $state->execute();
        return $this->db->lastInsertId();
    }


    function updateContrato(Contrato $contrato)
    {
        $sql = "UPDATE tb_contrato SET ds_statuscli = :status_usuario, cd_jog = :id_jog, ds_statusjog = :status_jogador, ds_negou = :motivo_recusa, ds_statuscontrato = :statuscontrato, ds_data = :dataatual,
        ds_avaliacao = :avaliacao, no_notaavaliacao = :notaavaliacao, vl_valor = :valor, perc_jog = :perc_jogador WHERE cd_contrato = :contrato_id";

        $state = $this->db->prepare($sql);
        $arrayContrato = $contrato->toArray();
        $state->bindParam(":status_usuario", $arrayContrato["statusCliente"]);
        $state->bindParam(":status_jogador", $arrayContrato["statusJogador"]);
        $state->bindParam(":motivo_recusa", $arrayContrato["motivoRecusa"]);
        $state->bindParam(":contrato_id", $arrayContrato["id"]);
        $state->bindParam(":id_jog", $arrayContrato["idJogador"]);
        $state->bindParam(":statuscontrato", $arrayContrato["statusContrato"]);
        $state->bindParam(":avaliacao", $arrayContrato["avaliacao"]);
        $state->bindParam(":notaavaliacao", $arrayContrato["notaAvaliacao"]);
        $state->bindParam(":valor", $arrayContrato["valor"]);
        $state->bindParam(":perc_jogador", $arrayContrato["percentualJogador"]);
        $actualdata = date('Y-m-d H:i:s');
        $state->bindParam(":dataatual", $actualdata);
        $state->execute();
        return $this->db->lastInsertId();
    }

    function getContratoById($id)
    {
        $sql = "SELECT * FROM tb_contrato WHERE cd_contrato = :id";
        $state = $this->db->prepare($sql);
        $state->bindParam(":id", $id);
        $state->execute();
        return $this->mapToContrato($state->fetch());
    }

    function getContratoByJogadorId($id)
    {
        $sql = "SELECT
            tb_cliente.cd_cli,
            tb_cliente.name_cli,
            tb_cliente.ds_email as ds_email_cli,
            tb_cliente.no_tel as no_tel_cli,
            tb_jog_profis.cd_jog,
            tb_jog_profis.name_jog,
            tb_jog_profis.ds_email as ds_email_jog,
            tb_jog_profis.no_tel as no_tel_jog,
            tb_jog_profis.ds_rank,
            tb_servico.*,
            tb_contrato.cd_contrato,
            tb_contrato.cd_cli as cd_cli_contrato,
            tb_contrato.cd_jog as cd_jog_contrato,
            tb_contrato.cd_serv as cd_serv_contrato,
            tb_contrato.ds_statusjog,
            tb_contrato.ds_statuscli,
            tb_contrato.ds_statuscontrato,
            tb_contrato.vl_valor,
            tb_contrato.perc_jog,
            tb_contrato.ds_data as ds_data_contrato,
            tb_contrato.ds_avaliacao,
            tb_contrato.no_notaavaliacao,
            tb_contrato.ds_negou
            FROM tb_contrato
            LEFT JOIN tb_jog_profis ON tb_contrato.cd_jog = tb_jog_profis.cd_jog
            INNER JOIN tb_cliente ON tb_contrato.cd_cli = tb_cliente.cd_cli
            INNER JOIN tb_servico ON tb_contrato.cd_serv = tb_servico.cd_serv
            WHERE tb_contrato.cd_jog = :jogador_id";
        $state = $this->db->prepare($sql);
        $state->bindParam(":jogador_id", $id);
        $state->execute();
        return $state->fetchAll();
    }

    function getContratoByClienteId($id)
    {
        $sql = "SELECT
            tb_cliente.cd_cli,
            tb_cliente.name_cli,
            tb_cliente.ds_email as ds_email_cli,
            tb_cliente.no_tel as no_tel_cli,
            tb_jog_profis.cd_jog,
            tb_jog_profis.name_jog,
            tb_jog_profis.ds_email as ds_email_jog,
            tb_jog_profis.no_tel as no_tel_jog,
            tb_jog_profis.ds_rank,
            tb_servico.*,
            tb_contrato.cd_contrato,
            tb_contrato.cd_cli as cd_cli_contrato,
            tb_contrato.cd_jog as cd_jog_contrato,
            tb_contrato.cd_serv as cd_serv_contrato,
            tb_contrato.ds_statusjog,
            tb_contrato.ds_statuscli,
            tb_contrato.ds_statuscontrato,
            tb_contrato.vl_valor,
            tb_contrato.perc_jog,
            tb_contrato.ds_data as ds_data_contrato,
            tb_contrato.ds_avaliacao,
            tb_contrato.no_notaavaliacao,
            tb_contrato.ds_negou
            FROM tb_contrato
            LEFT JOIN tb_jog_profis ON tb_contrato.cd_jog = tb_jog_profis.cd_jog
            INNER JOIN tb_cliente ON tb_contrato.cd_cli = tb_cliente.cd_cli
            INNER JOIN tb_servico ON tb_contrato.cd_serv = tb_servico.cd_serv
            WHERE tb_contrato.cd_cli = :usuario_id";
        $state = $this->db->prepare($sql);
        $state->bindParam(":usuario_id", $id);
        $state->execute();
        return $state->fetchAll();
    }

    function getContratosPendentes()
    {
        $sql = "SELECT
            tb_cliente.cd_cli, tb_cliente.name_cli, tb_cliente.ds_email, tb_cliente.no_tel, tb_jog_profis.cd_jog, tb_jog_profis.name_jog, tb_jog_profis.no_tel,
            tb_jog_profis.ds_rank,
            tb_servico.*,
            tb_contrato.*
            FROM tb_contrato
            LEFT JOIN tb_jog_profis ON tb_contrato.cd_jog = tb_jog_profis.cd_jog
            INNER JOIN tb_cliente ON tb_contrato.cd_cli = tb_cliente.cd_cli
            INNER JOIN tb_servico ON tb_contrato.cd_serv = tb_servico.cd_serv
            WHERE tb_contrato.ds_statusjog  = 'buscando'";
        $state = $this->db->prepare($sql);
        $state->execute();
        return $state->fetchAll();
    }

    public function mapToContrato($row)
    {
        return new Contrato(
            $row["cd_contrato"],
            $row["cd_cli"],
            $row["cd_jog"],
            $row["cd_serv"],
            $row["ds_statusjog"],
            $row["ds_statuscli"],
            $row["ds_statuscontrato"],
            $row["vl_valor"],
            $row["perc_jog"],
            $row["ds_data"],
            $row["ds_avaliacao"],
            $row["no_notaavaliacao"],
            $row["ds_negou"]
        );
    }
}
