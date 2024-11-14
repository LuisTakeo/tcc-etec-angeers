<?php

namespace models;

// create table restricao
// (
// 	cd_rest INT primary key auto_increment,
// 	cd_cli	INT NOT NULL,
//     cd_jog INT NOT NULL,
//     dt_rest timestamp default current_timestamp,
//     CONSTRAINT fk_restricaocliente foreign key (cd_cli) REFERENCES tb_cliente(cd_cli),
//     CONSTRAINT fk_restricaojogador foreign key (cd_jog) REFERENCES tb_jog_profis(cd_jog)
// );
// use a linha acima como referencia para criar a classe Restricao, com nomes friendly
class Restricao
{
    protected $idRestricao;
    protected $idCliente;
    protected $idJogador;
    protected $dataRestricao;

    public function __construct($idRestricao, $idCliente, $idJogador, $dataRestricao)
    {
        $this->idRestricao = $idRestricao;
        $this->idCliente = $idCliente;
        $this->idJogador = $idJogador;
        $this->dataRestricao = $dataRestricao;
    }

    public function getIdRestricao() { return $this->idRestricao; }
    public function getIdCliente() { return $this->idCliente; }
    public function getIdJogador() { return $this->idJogador; }
    public function getDataRestricao() { return $this->dataRestricao; }

    public function setIdRestricao($idRestricao) { $this->idRestricao = $idRestricao; }
    public function setIdCliente($idCliente) { $this->idCliente = $idCliente; }
    public function setIdJogador($idJogador) { $this->idJogador = $idJogador; }
    public function setDataRestricao($dataRestricao) { $this->dataRestricao = $dataRestricao; }

    public function toArray()
    {
        return [
            "idRestricao" => $this->idRestricao,
            "idCliente" => $this->idCliente,
            "idJogador" => $this->idJogador,
            "dataRestricao" => $this->dataRestricao
        ];
    }
}