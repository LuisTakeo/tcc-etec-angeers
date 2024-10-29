<?php
namespace models;

// require_once("Usuario.php");

class Jogador extends Usuario
{
    private $rank;

    public function __construct($id, $name, $senha, $tel, $email, $cpf, $ativo, $dataInclusao, $dataExclusao, $rank)
    {
        parent::__construct($id, $name, $senha, $tel, $email, $cpf, $ativo, $dataInclusao, $dataExclusao);
        $this->rank = $rank;
    }

    public function getRank() { return $this->rank; }
    public function setRank($rank) { $this->rank = $rank; }

    public function toArray()
    {
        $array = parent::toArray();
        $array["rank"] = $this->rank;
        return $array;
    }
}