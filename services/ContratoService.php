<?php
namespace services;

use models\Contrato;
use repository\ContratoRepository;

class ContratoService
{
    private $contratoRepository;

    public function __construct(ContratoRepository $contratoRepository)
    {
        $this->contratoRepository = $contratoRepository;
    }

    public function createContrato(Contrato $newContrato)
    {
        try
        {
            $this->contratoRepository->beginTransaction();
            $lastId = $this->contratoRepository->createContrato($newContrato);
            $this->contratoRepository->commit();
            return "Contrato criado com sucesso " . $lastId;
        }
        catch (\PDOException $err)
        {
            $this->contratoRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }

    public function updateContrato(Contrato $contrato)
    {
        try
        {
            $this->contratoRepository->beginTransaction();
            $this->contratoRepository->updateContrato($contrato);
            $this->contratoRepository->commit();
            return "Contrato atualizado com sucesso";
        }
        catch (\PDOException $err)
        {
            $this->contratoRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }

    public function updateContratoStatus(Contrato $contrato)
    {
        try
        {
            $this->contratoRepository->beginTransaction();
            $this->contratoRepository->updateContrato($contrato);
            $this->contratoRepository->commit();
            return "Contrato atualizado com sucesso";
        }
        catch (\PDOException $err)
        {
            $this->contratoRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }

    public function getContratoById($id)
    {
        return $this->contratoRepository->getContratoById($id);
    }

    public function getContratoByClienteId($id)
    {
        $list = $this->contratoRepository->getContratoByClienteId($id);
        if (empty($list))
        {
            throw new \PDOException("Nenhum contrato encontrado");
        }
        $filteredList = array_map(function($contrato)
        {
            $array_contrato = [
                "contrato" => [
                    "id" => $contrato["cd_contrato"],
                    "idCliente" => $contrato["cd_cli_contrato"],
                    "idJogador" => $contrato["cd_jog_contrato"],
                    "idServico" => $contrato["cd_serv_contrato"],
                    "statusJogador" => $contrato["ds_statusjog"],
                    "statusCliente" => $contrato["ds_statuscli"],
                    "statusContrato" => $contrato["ds_statuscontrato"],
                    "valor" => $contrato["vl_valor"],
                    "percentualJogador" => $contrato["perc_jog"],
                    "dataInicio" => $contrato["ds_data_contrato"],
                    "avaliacao" => $contrato["ds_avaliacao"],
                    "notaAvaliacao" => $contrato["no_notaavaliacao"],
                    "motivoRecusa" => $contrato["ds_negou"]
                ],
                "cliente" => [
                    "id" => $contrato["cd_cli"],
                    "nome" => $contrato["name_cli"],
                    "email" => $contrato["ds_email_cli"],
                    "telefone" => $contrato["no_tel_cli"],
                ],
                "jogador" => [
                    "id" => $contrato["cd_jog"],
                    "nome" => $contrato["name_jog"],
                    "telefone" => $contrato["no_tel_jog"],
                    "rank" => $contrato["ds_rank"],
                    "email" => $contrato["ds_email_jog"]
                ],
                "servico" => [
                    "id" => $contrato["cd_serv"],
                    "nome" => $contrato["nm_serv"],
                    "descricao" => $contrato["ds_serv"],
                    "valor" => $contrato["vl_serv"],
                    "statusServico" => $contrato["ds_status"]
                ]
                ];
            return $array_contrato;
        }, $list);
        return $filteredList;
    }

    public function getContratoByJogadorId($id)
    {
        $list = $this->contratoRepository->getContratoByJogadorId($id);
        if (empty($list))
        {
            throw new \PDOException("Nenhum contrato encontrado");
        }
        $filteredList = array_map(function($contrato)
        {
            $array_contrato = [
                "contrato" => [
                    "id" => $contrato["cd_contrato"],
                    "idCliente" => $contrato["cd_cli_contrato"],
                    "idJogador" => $contrato["cd_jog_contrato"],
                    "idServico" => $contrato["cd_serv_contrato"],
                    "statusJogador" => $contrato["ds_statusjog"],
                    "statusCliente" => $contrato["ds_statuscli"],
                    "statusContrato" => $contrato["ds_statuscontrato"],
                    "valor" => $contrato["vl_valor"],
                    "percentualJogador" => $contrato["perc_jog"],
                    "dataInicio" => $contrato["ds_data_contrato"],
                    "avaliacao" => $contrato["ds_avaliacao"],
                    "notaAvaliacao" => $contrato["no_notaavaliacao"],
                    "motivoRecusa" => $contrato["ds_negou"]
                ],
                "cliente" => [
                    "id" => $contrato["cd_cli"],
                    "nome" => $contrato["name_cli"],
                    "email" => $contrato["ds_email_cli"],
                    "telefone" => $contrato["no_tel_cli"],
                ],
                "jogador" => [
                    "id" => $contrato["cd_jog"],
                    "nome" => $contrato["name_jog"],
                    "telefone" => $contrato["no_tel_jog"],
                    "rank" => $contrato["ds_rank"],
                    "email" => $contrato["ds_email_jog"]
                ],
                "servico" => [
                    "id" => $contrato["cd_serv"],
                    "nome" => $contrato["nm_serv"],
                    "descricao" => $contrato["ds_serv"],
                    "valor" => $contrato["vl_serv"],
                    "statusServico" => $contrato["ds_status"]
                ]
                ];
            return $array_contrato;
        }, $list);
        return $filteredList;
    }

    public function getContratosPendentes()
    {
        $list = $this->contratoRepository->getContratosPendentes();
        if (empty($list))
        {
            throw new \PDOException("Nenhum contrato pendente encontrado");
        }
        $filteredList = array_map(function($contrato)
        {
            $array_contrato = [
                "contrato" => [
                    "id" => $contrato["cd_contrato"],
                    "idCliente" => $contrato["cd_cli_contrato"],
                    "idJogador" => $contrato["cd_jog_contrato"],
                    "idServico" => $contrato["cd_serv_contrato"],
                    "statusJogador" => $contrato["ds_statusjog"],
                    "statusCliente" => $contrato["ds_statuscli"],
                    "statusContrato" => $contrato["ds_statuscontrato"],
                    "valor" => $contrato["vl_valor"],
                    "percentualJogador" => $contrato["perc_jog"],
                    "dataInicio" => $contrato["ds_data_contrato"],
                    "avaliacao" => $contrato["ds_avaliacao"],
                    "notaAvaliacao" => $contrato["no_notaavaliacao"],
                    "motivoRecusa" => $contrato["ds_negou"]
                ],
                "cliente" => [
                    "id" => $contrato["cd_cli"],
                    "nome" => $contrato["name_cli"],
                    "email" => $contrato["ds_email_cli"],
                    "telefone" => $contrato["no_tel_cli"],
                ],
                "jogador" => [
                    "id" => $contrato["cd_jog"],
                    "nome" => $contrato["name_jog"],
                    "telefone" => $contrato["no_tel_jog"],
                    "rank" => $contrato["ds_rank"],
                    "email" => $contrato["ds_email_jog"]
                ],
                "servico" => [
                    "id" => $contrato["cd_serv"],
                    "nome" => $contrato["nm_serv"],
                    "descricao" => $contrato["ds_serv"],
                    "valor" => $contrato["vl_serv"],
                    "statusServico" => $contrato["ds_status"]
                ]
                ];
            return $array_contrato;
        }, $list);
        return $filteredList;
    }
}