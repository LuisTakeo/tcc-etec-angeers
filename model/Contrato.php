<?php
namespace models;

class Contrato
{
    private $id;
    private $idCliente;
    private $idJogador;
    private $id_servico;
    private $statusJogador;
    private $statusCliente;
    private $statusContrato;
    private $valor;
    private $percentualJogador;
    private $dataInicio;
    private $avaliacao;
    private $notaAvaliacao;
    private $motivoRecusa;

    public function __construct($id, $idCliente, $idJogador, $id_servico, $statusJogador, $statusCliente, $statusContrato, $valor, $percentualJogador, $dataInicio, $avaliacao, $notaAvaliacao, $motivoRecusa)
    {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->idJogador = $idJogador;
        $this->id_servico = $id_servico;
        $this->statusJogador = $statusJogador;
        $this->statusCliente = $statusCliente;
        $this->statusContrato = $statusContrato;
        $this->valor = $valor;
        $this->percentualJogador = $percentualJogador;
        $this->dataInicio = $dataInicio;
        $this->avaliacao = $avaliacao;
        $this->notaAvaliacao = $notaAvaliacao;
        $this->motivoRecusa = $motivoRecusa;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getIdJogador()
    {
        return $this->idJogador;
    }

    public function setIdJogador($idJogador)
    {
        $this->idJogador = $idJogador;
    }

    public function getId_servico()
    {
        return $this->id_servico;
    }

    public function setId_servico($id_servico)
    {
        $this->id_servico = $id_servico;
    }

    public function getStatusJogador()
    {
        return $this->statusJogador;
    }

    public function setStatusJogador($statusJogador)
    {
        $this->statusJogador = $statusJogador;
    }

    public function getStatusCliente()
    {
        return $this->statusCliente;
    }

    public function setStatusCliente($statusCliente)
    {
        $this->statusCliente = $statusCliente;
    }

    public function getStatusContrato()
    {
        return $this->statusContrato;
    }

    public function setStatusContrato($statusContrato)
    {
        $this->statusContrato = $statusContrato;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getPercentualJogador()
    {
        return $this->percentualJogador;
    }

    public function setPercentualJogador($percentualJogador)
    {
        $this->percentualJogador = $percentualJogador;
    }

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    public function getAvaliacao()
    {
        return $this->avaliacao;
    }

    public function setAvaliacao($avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }

    public function getNotaAvaliacao()
    {
        return $this->notaAvaliacao;
    }

    public function setNotaAvaliacao($notaAvaliacao)
    {
        $this->notaAvaliacao = $notaAvaliacao;
    }

    public function getMotivoRecusa()
    {
        return $this->motivoRecusa;
    }

    public function setMotivoRecusa($motivoRecusa)
    {
        $this->motivoRecusa = $motivoRecusa;
    }


    public function toArray()
    {
        return [
            "id" => $this->id,
            "idCliente" => $this->idCliente,
            "idJogador" => $this->idJogador,
            "id_servico" => $this->id_servico,
            "statusJogador" => $this->statusJogador,
            "statusCliente" => $this->statusCliente,
            "statusContrato" => $this->statusContrato,
            "valor" => $this->valor,
            "percentualJogador" => $this->percentualJogador,
            "dataInicio" => $this->dataInicio,
            "avaliacao" => $this->avaliacao,
            "notaAvaliacao" => $this->notaAvaliacao,
            "motivoRecusa" => $this->motivoRecusa
        ];
    }
}