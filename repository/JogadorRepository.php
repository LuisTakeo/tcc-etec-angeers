<?php
namespace repository;

use models\Jogador;

class JogadorRepository
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

    public function create(Jogador $new_jogador)
    {
        $sql = "INSERT INTO tb_jog_profis
            (name_jog, ds_senha, no_tel, ds_email, no_cpf, jogador_ativo, data_inclusao,
            data_exclusao, ds_rank)
            values
            (:name_jog, :ds_senha, :no_tel, :ds_email, :no_cpf, :jogador_ativo, :data_inclusao, :data_exclusao, :ds_rank)";
        $state = $this->db->prepare($sql);
        $array_jogador = $new_jogador->toArray();
        $state->bindParam(':name_jog', $array_jogador["name"]);
        $state->bindParam(':ds_senha', $array_jogador["senha"]);
        $state->bindParam(':no_tel', $array_jogador["tel"]);
        $state->bindParam(':ds_email', $array_jogador["email"]);
        $state->bindParam(':no_cpf', $array_jogador["cpf"]);
        $state->bindParam(':jogador_ativo', $array_jogador["jogador_ativo"]);
        $state->bindParam(':data_inclusao', $array_jogador["data_inclusao"]);
        $state->bindParam(':data_exclusao', $array_jogador["data_exclusao"]);
        $state->bindParam(':ds_rank', $array_jogador["rank"]);
        $state->execute();

    }

    public function updateJogador(Jogador $jogador)
    {
        $sql = "UPDATE tb_jog_profis SET name_jog = :name_jog, ds_senha = :ds_senha, no_tel = :no_tel, ds_email = :ds_email, no_cpf = :no_cpf, jogador_ativo = :jogador_ativo, data_inclusao = :data_inclusao, data_exclusao = :data_exclusao, ds_rank = :ds_rank WHERE cd_jog = :cd_jog";
        $state = $this->db->prepare($sql);
        $array_jogador = $jogador->toArray();
        $state->bindParam(':cd_jog', $array_jogador["id"]);
        $state->bindParam(':name_jog', $array_jogador["name"]);
        $state->bindParam(':ds_senha', $array_jogador["senha"]);
        $state->bindParam(':no_tel', $array_jogador["tel"]);
        $state->bindParam(':ds_email', $array_jogador["email"]);
        $state->bindParam(':no_cpf', $array_jogador["cpf"]);
        $state->bindParam(':jogador_ativo', $array_jogador["jogador_ativo"]);
        $state->bindParam(':data_inclusao', $array_jogador["data_inclusao"]);
        $state->bindParam(':data_exclusao', $array_jogador["data_exclusao"]);
        $state->bindParam(':ds_rank', $array_jogador["rank"]);
        $state->execute();
        return $state->rowCount();
    }

    public function getJogador($id)
    {
        $sql = "SELECT * FROM tb_jog_profis WHERE cd_jog = :id";
        $state = $this->db->prepare($sql);
        $state->bindParam(':id', $id);
        $state->execute();
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Jogador não encontrado");
        return $this->mapToJogador($result);
    }

    public function getJogadorByEmail($email)
    {
        $sql = "SELECT * FROM tb_jog_profis WHERE ds_email = :email";
        $state = $this->db->prepare($sql);
        $state->bindParam(':email', $email);
        $state->execute();
        if ($state->rowCount() == 0)
            throw new \PDOException("Jogador não encontrado");
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Jogador não encontrado");
        return $this->mapToJogador($result);
    }

    public function getJogadores()
    {
        $sql = "SELECT * FROM tb_jog_profis";
        $state = $this->db->prepare($sql);
        $state->execute();
        $result = $state->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Nenhum jogador encontrado");
        return $result;
    }

    public function softDeleteJogador($id)
    {
        $sql = "UPDATE tb_jog_profis SET jogador_ativo = 0, data_exclusao = NOW() WHERE cd_jog = :cd_jog";
        $state = $this->db->prepare($sql);
        $state->bindParam(':cd_jog', $id);
        $state->execute();
        return $state->rowCount();
    }

    public function mapToJogador($data)
    {
        if (!$data)
            return NULL;
        return new Jogador(
            $data["cd_jog"],
            $data["name_jog"],
            $data["ds_senha"],
            $data["no_tel"],
            $data["ds_email"],
            $data["no_cpf"],
            $data["jogador_ativo"],
            $data["data_inclusao"],
            $data["data_exclusao"],
            $data["ds_rank"]);
    }
}