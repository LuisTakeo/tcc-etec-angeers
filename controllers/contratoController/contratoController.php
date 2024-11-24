<?php
namespace controllers\contratoController;

use models\Contrato;
use repository\ContratoRepository;
use services\ContratoService;
use PDO;
use PDOException;

// regras de negocio do status do usuario
// solicitado = aguardando resposta do jogador selecionado
// buscando = aguardando resposta de jogadores
// recusado = contrato recusado pelo usuario
// aceito = contrato aceito pelo usuario

// regras de negocio do status do jogador
// aceito = contrato aceito pelo jogador
// recusado = contrato recusado pelo jogador
// aguardando resposta = contrato aguardando resposta do jogador
// buscando = aguardando resposta de jogadores

// regras de negocio do status do contrato
// pendente = contrato pendente de aceitação
// ativo = contrato ativo
// finalizado = contrato finalizado


class ContratoController
{
    private $db;
    private $contratoService;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $contratoRepository = new ContratoRepository($this->db);
        $this->contratoService = new ContratoService($contratoRepository);
    }

    public function createContratoPendente($usuario_id, $servico_id, $data_inicio, $valor, $percentual)
    {
        try
        {
            $novoContrato = new Contrato(
                NULL,
                $usuario_id,
                NULL,
                $servico_id,
                "buscando",
                "buscando",
                "pendente",
                $valor,
                $percentual,
                $data_inicio,
                NULL,
                NULL,
                NULL);
            $lastId = $this->contratoService->createContrato($novoContrato);
            echo $lastId;
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    public function createContratoComJogador($usuario_id, $jogador_id, $servico_id, $data_inicio, $valor, $percentual)
    {
        try
        {
            // #TODO fazer ciclo para verificar se jogador não está na lista de restritos
            $novoContrato = new Contrato(
                NULL,
                $usuario_id,
                $jogador_id,
                $servico_id,
                "aguardando",
                "solicitado",
                "pendente",
                $valor,
                $percentual,
                $data_inicio,
                NULL,
                NULL,
                NULL);
            $lastId = $this->contratoService->createContrato($novoContrato);
            echo $lastId;
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    public function updateContratoStatus(Contrato $contrato, $status_usuario, $status_jogador, $status_contrato, $motivo_recusa = null)
    {
        try
        {
            $contrato->setStatusCliente($status_usuario);
            $contrato->setStatusJogador($status_jogador);
            $contrato->setStatusContrato($status_contrato);
            $contrato->setMotivoRecusa($motivo_recusa);
            return $this->contratoService->updateContratoStatus($contrato);
        } catch (PDOException $err)
        {
            echo $err->getMessage();
            return NULL;
        }
    }

    public function setContratoToAceito($contrato_id)
    {
        try
        {
            $contrato = $this->getContrato($contrato_id);
            return $this->updateContratoStatus($contrato, "aceito", "aceito", "ativo");
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    public function setContratoToRecusado($contrato_id, $motivo_recusa)
    {
        try
        {
            $contrato = $this->getContrato($contrato_id);
            if (!$contrato)
                throw new PDOException("Contrato não encontrado");
            return $this->updateContratoStatus($contrato, "recusado", "recusado", "finalizado", $motivo_recusa);
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }





    function getContrato($contrato_id)
    {
        try
        {
            $contrato = $this->contratoService->getContratoById($contrato_id);
            return $contrato;
        } catch (PDOException $err)
        {
            echo $err->getMessage();
            return NULL;
        }
    }

    public function setAvaliacaoContrato($contrato_id, $avaliacao, $notaAvaliacao)
    {
        try
        {
            $contrato = $this->getContrato($contrato_id);
            if (!$contrato)
                throw new PDOException("Contrato não encontrado");
            if ($contrato->getStatusContrato() != "finalizado")
                throw new PDOException("Contrato não finalizado");
            $contrato->setAvaliacao($avaliacao);
            $contrato->setNotaAvaliacao($notaAvaliacao);
            return $this->contratoService->updateContrato($contrato);
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    public function setContratoToFinalizado($contrato_id)
    {
        try
        {
            $contrato = $this->getContrato($contrato_id);
            if (!$contrato)
                throw new PDOException("Contrato não encontrado");
            if ($contrato->getStatusContrato() != "ativo")
                throw new PDOException("Contrato não ativo");
            return $this->updateContratoStatus($contrato, "aceito", "aceito", "finalizado");
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    function getContratosByUsuario($usuario_id)
    {
        try
        {
            $contratos = $this->contratoService->getContratoByClienteId($usuario_id);
            return $contratos;
        } catch (PDOException $err)
        {
            throw new PDOException($err->getMessage());
        }
    }

    function getContratosByJogador($jogador_id)
    {
        try
        {
            $contratos = $this->contratoService->getContratoByJogadorId($jogador_id);
            return $contratos;
        } catch (PDOException $err)
        {
            throw new PDOException($err->getMessage());
        }
    }

    function filterContratosPendentesByUsuario($usuario_id)
    {
        try
        {
            $contratos = $this->getContratosByUsuario($usuario_id);
            if (empty($contratos))
                throw new PDOException("Nenhum contrato encontrado");
            $contratosFiltered = array_filter($contratos, function ($contrato)
            {
                return $contrato["contrato"]["statusContrato"] == "pendente";
            });
            $contratosFiltered = array_values($contratosFiltered);
            return $contratosFiltered;
        } catch (PDOException $err)
        {
            throw new PDOException($err->getMessage());
        }
    }

    function getContratosPendentes()
    {
        try
        {
            $contratos = $this->contratoService->getContratosPendentes();

            return $contratos;
        } catch (PDOException $err)
        {
            throw new PDOException($err->getMessage());
        }
    }

}

function createContrato(PDO $connect, int $usuario_id, int $jogador_id, int $servico_id, string $data_inicio, float $valor)
{
    $sql = "INSERT INTO tb_contrato (cd_cli, cd_jog, cd_serv, ds_statusjog, ds_statuscli, perc_jog, ds_data, ds_statuscontrato, vl_valor)
            VALUES (:usuario_id, :jogador_id, :servico_id, 'aguardando', 'solicitado', 0.6, :data_inicio, 'pendente', :valor)";
    $state = $connect->prepare($sql);
    $state->bindParam(":usuario_id", $usuario_id);
    $state->bindParam(":jogador_id", $jogador_id);
    $state->bindParam(":servico_id", $servico_id);
    $state->bindParam(":data_inicio", $data_inicio);
    $state->bindParam(":valor", $valor);
    $state->execute();
    return $connect->lastInsertId();
}

function createContratoPendente(\PDO $connect, int $usuario_id, int $servico_id, string $data_inicio, float $valor)
{
    $sql = "INSERT INTO tb_contrato (cd_cli, cd_serv, ds_statusjog, ds_statuscli, perc_jog, ds_data, ds_statuscontrato, vl_valor)
            VALUES (:usuario_id, :servico_id, 'buscando', 'buscando', 0.60, :data_inicio, 'pendente', :valor)";
    $state = $connect->prepare($sql);
    $state->bindParam(":usuario_id", $usuario_id);
    $state->bindParam(":servico_id", $servico_id);
    $state->bindParam(":data_inicio", $data_inicio);
    $state->bindParam(":valor", $valor);
    $state->execute();
    return $connect->lastInsertId();
}

function updateContratoStatus(\PDO $connect, int $contrato_id, string $status_usuario, string $status_jogador, string $status_contrato, string $motivo_recusa = null)
{
    $sql = "UPDATE tb_contrato SET ds_statuscli = :status_usuario, ds_statusjog = :status_jogador, ds_negou = :motivo_recusa, ds_statuscontrato = :statuscontrato, ds_data = :dataatual WHERE cd_contrato = :contrato_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":status_usuario", $status_usuario);
    $state->bindParam(":status_jogador", $status_jogador);
    $state->bindParam(":motivo_recusa", $motivo_recusa);
    $state->bindParam(":contrato_id", $contrato_id);
    $state->bindParam(":statuscontrato", $status_contrato);
    $actualdata = date('Y-m-d H:i:s');
    $state->bindParam(":dataatual", $actualdata);
    $state->execute();
}

function updateContratoStatusPendente(\PDO $connect, int $contrato_id, int $id_jog, string $status_usuario, string $status_jogador, string $status_contrato, string $motivo_recusa = null)
{
    $sql = "UPDATE tb_contrato SET ds_statuscli = :status_usuario, cd_jog = :id_jog, ds_statusjog = :status_jogador, ds_negou = :motivo_recusa, ds_statuscontrato = :statuscontrato, ds_data = :dataatual WHERE cd_contrato = :contrato_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":status_usuario", $status_usuario);
    $state->bindParam(":status_jogador", $status_jogador);
    $state->bindParam(":motivo_recusa", $motivo_recusa);
    $state->bindParam(":contrato_id", $contrato_id);
    $state->bindParam(":id_jog", $id_jog);
    $state->bindParam(":statuscontrato", $status_contrato);
    $actualdata = date('Y-m-d H:i:s');
    $state->bindParam(":dataatual", $actualdata);
    $state->execute();
}

function getContrato(PDO $connect, int $id)
{
    $sql = "SELECT * FROM tb_contrato WHERE cd_contrato = :id";
    $state = $connect->prepare($sql);
    $state->bindParam(":id", $id);
    $state->execute();
    $result = $state->fetch(\PDO::FETCH_ASSOC);
    if (!$result)
        throw new PDOException("Nenhum contrato encontrado");
    return $result;
}

function getContratosByUsuario(\PDO $connect, int $usuario_id)
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
    WHERE tb_contrato.cd_cli = :usuario_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":usuario_id", $usuario_id);
    $state->execute();
    return $state->fetchAll(\PDO::FETCH_ASSOC);
}



function getContratosByJogador(\PDO $connect, int $jogador_id)
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
    WHERE tb_contrato.cd_jog = :jogador_id";
    $state = $connect->prepare($sql);
    $state->bindParam(":jogador_id", $jogador_id);
    $state->execute();
    return $state->fetchAll(\PDO::FETCH_ASSOC);
}

function getContratosPendentes(\PDO $connect)
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
    $state = $connect->prepare($sql);
    $state->execute();
    return $state->fetchAll(\PDO::FETCH_ASSOC);
}

// Adicione outras funções conforme necessário, como deleteContrato, etc.
?>