<?php
namespace repository;

use models\Usuario;
use models\Restricao;

use function PHPSTORM_META\map;

class UsuarioRepository
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

    public function create(Usuario $new_client)
    {
        $sql = "INSERT INTO tb_cliente
            (name_cli, ds_senha, no_tel, ds_email, no_cpf, cliente_ativo, data_inclusao,
            data_exclusao)
            values
            (:name_cli, :ds_senha, :no_tel, :ds_email, :no_cpf, :cliente_ativo, :data_inclusao, :data_exclusao)";
        $state = $this->db->prepare($sql);
        $array_client = $new_client->toArray();
        $state->bindParam(':name_cli', $array_client["name"]);
        $state->bindParam(':ds_senha', $array_client["senha"]);
        $state->bindParam(':no_tel', $array_client["tel"]);
        $state->bindParam(':ds_email', $array_client["email"]);
        $state->bindParam(':no_cpf', $array_client["cpf"]);
        $state->bindParam(':cliente_ativo', $array_client["ativo"]);
        $state->bindParam(':data_inclusao', $array_client["dataInclusao"]);
        $state->bindParam(':data_exclusao', $array_client["dataExclusao"]);
        $state->execute();
    }

    function updateCliente(Usuario $client)
    {
        $sql = "UPDATE tb_cliente SET name_cli = :name_cli, ds_senha = :ds_senha, no_tel = :no_tel, ds_email = :ds_email, no_cpf = :no_cpf, cliente_ativo = :cliente_ativo, data_inclusao = :data_inclusao, data_exclusao = :data_exclusao WHERE cd_cli = :cd_cli";
        $state = $this->db->prepare($sql);
        $array_client = $client->toArray();
        $state->bindParam(':cd_cli', $array_client["id"]);
        $state->bindParam(':name_cli', $array_client["name"]);
        $state->bindParam(':ds_senha', $array_client["senha"]);
        $state->bindParam(':no_tel', $array_client["tel"]);
        $state->bindParam(':ds_email', $array_client["email"]);
        $state->bindParam(':no_cpf', $array_client["cpf"]);
        $state->bindParam(':cliente_ativo', $array_client["ativo"]);
        $state->bindParam(':data_inclusao', $array_client["dataInclusao"]);
        $state->bindParam(':data_exclusao', $array_client["dataExclusao"]);
        $state->execute();
    }

    public function getCliente($id)
    {
        $sql = "SELECT * FROM tb_cliente WHERE cd_cli = :id";
        $state = $this->db->prepare($sql);
        $state->bindParam(':id', $id);
        $state->execute();
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Cliente não encontrado");
        return $this->mapToUsuario($result);
    }

    public function getClienteByEmail($email)
    {
        $sql = "SELECT * FROM tb_cliente WHERE ds_email = :email";
        $state = $this->db->prepare($sql);
        $state->bindParam(':email', $email);
        $state->execute();
        if ($state->rowCount() == 0)
            throw new \PDOException("Cliente não encontrado");
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Cliente não encontrado");
        return $this->mapToUsuario($result);
    }

    public function getClientes()
    {
        $sql = "SELECT * FROM tb_cliente";
        $state = $this->db->prepare($sql);
        $state->execute();
        $result = $state->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Nenhum cliente encontrado");
        return array_map(function ($data) {
            return $this->mapToUsuario($data);
        }, $result);
    }

    private function mapToUsuario($data)
    {
        if (!$data) {
            return null;
        }
        return new Usuario(
            $data['cd_cli'],
            $data['name_cli'],
            $data['ds_senha'],
            $data['no_tel'],
            $data['ds_email'],
            $data['no_cpf'],
            $data['cliente_ativo'],
            $data['data_inclusao'],
            $data['data_exclusao']
        );
    }

    private function mapToRestricao($data)
    {
        if (!$data) {
            return null;
        }
        return new Restricao(
            $data['cd_rest'],
            $data['cd_cli'],
            $data['cd_jog'],
            $data['dt_rest']
        );
    }

    public function getRestricaoUsuario($id)
    {
        $sql = "SELECT * FROM restricao WHERE cd_cli = :cd_cli";
        $state = $this->db->prepare($sql);
        $state->bindParam(':cd_cli', $id);
        $state->execute();
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Restrição não encontrada");
        return $this->mapToRestricao($result);
    }

    public function createRestricao(Restricao $restricao)
    {
        $sql = "INSERT INTO restricao (cd_cli, cd_jog, dt_rest) VALUES (:cd_cli, :cd_jog, :dt_rest)";
        $state = $this->db->prepare($sql);
        $array_restricao = $restricao->toArray();
        $state->bindParam(':cd_cli', $array_restricao["idCliente"]);
        $state->bindParam(':cd_jog', $array_restricao["idJogador"]);
        $state->bindParam(':dt_rest', $array_restricao["dataRestricao"]);
        $state->execute();
    }
}