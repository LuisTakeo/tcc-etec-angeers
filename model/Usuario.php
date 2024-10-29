<?php
namespace models;

class Usuario
{
    protected $id;
    protected $name;
    protected $senha;
    protected $tel;
    protected $email;
    protected $cpf;
    protected $ativo;
    protected $dataInclusao;
    protected $dataExclusao;

    public function __construct($id, $name, $senha, $tel, $email, $cpf, $ativo, $dataInclusao, $dataExclusao)
    {
        $this->id = $id;
        $this->name = $name;
        $this->senha = $senha;
        $this->tel = $tel;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->ativo = $ativo;
        $this->dataInclusao = $dataInclusao;
        $this->dataExclusao = $dataExclusao;
    }

    // Getters e setters para cada atributo
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSenha() { return $this->senha; }
    public function getTel() { return $this->tel; }
    public function getEmail() { return $this->email; }
    public function getCpf() { return $this->cpf; }
    public function getAtivo() { return $this->ativo; }
    public function getDataInclusao() { return $this->dataInclusao; }
    public function getDataExclusao() { return $this->dataExclusao; }

    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setSenha($senha) { $this->senha = $senha; }
    public function setTel($tel) { $this->tel = $tel; }
    public function setEmail($email) { $this->email = $email; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setAtivo($ativo) { $this->ativo = $ativo; }
    public function setDataInclusao($dataInclusao) { $this->dataInclusao = $dataInclusao; }
    public function setDataExclusao($dataExclusao) { $this->dataExclusao = $dataExclusao; }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "senha" => $this->senha,
            "tel" => $this->tel,
            "email" => $this->email,
            "cpf" => $this->cpf,
            "ativo" => $this->ativo,
            "dataInclusao" => $this->dataInclusao,
            "dataExclusao" => $this->dataExclusao
        ];
    }
}