<?php
namespace controllers\usuarioController;


function cadastrarCliente(\PDO $connect, array $new_client)
{
    try
    {
        $connect->beginTransaction(); // proteção para rollback
        if (!$new_client)
            throw new \PDOException("Empty array");
        $sql = "INSERT INTO tb_cliente
            (name_cli, ds_senha, no_tel, ds_email, no_cpf, cliente_ativo, data_inclusao,
            data_exclusao)
            values
            (:name_cli, :ds_senha, :no_tel, :ds_email, :no_cpf, :cliente_ativo, :data_inclusao, :data_exclusao)";
        $state = $connect->prepare($sql);
        $state->bindParam(':name_cli', $new_client["name"]);
        $state->bindParam(':ds_senha', $new_client["senha"]);
        $state->bindParam(':no_tel', $new_client["tel"]);
        $state->bindParam(':ds_email', $new_client["email"]);
        $state->bindParam(':no_cpf', $new_client["cpf"]);
        $state->bindParam(':cliente_ativo', $new_client["cliente_ativo"]);
        $state->bindParam(':data_inclusao', $new_client["data_inclusao"]);
        $state->bindParam(':data_exclusao', $new_client["data_exclusao"]);
        $state->execute();
        $connect->commit(); // confirma a transação
        echo "New record created successfully";
    } catch (\PDOException $err)
    {
        $connect->rollBack(); // desfaz a transação em caso de erro
        if ($err->getCode() == 23000)
            throw new \PDOException("Cliente já cadastrado com este CPF ou e-mail");
            // echo "Cliente já cadastrado com este CPF ou e-mail";
        else
            throw new \PDOException("Error: " . $err->getMessage());
    }
}

function getCliente(\PDO $connect, int $id)
{
    try
    {
        $sql = "SELECT * FROM tb_cliente WHERE id_cliente = :id";
        $state = $connect->prepare($sql);
        $state->bindParam(':id', $id);
        $state->execute();
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Cliente não encontrado");
        return $result;
    } catch (\PDOException $err)
    {
        throw new \PDOException("Error: " . $err->getMessage());
    }
}

function getClienteByEmail(\PDO $connect, string $email)
{
    try
    {
        $sql = "SELECT * FROM tb_cliente WHERE ds_email = :email";
        $state = $connect->prepare($sql);
        $state->bindParam(':email', $email);
        $state->execute();
        if ($state->rowCount() == 0)
            throw new \PDOException("Cliente não encontrado");
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Cliente não encontrado");
        return $result;
    } catch (\PDOException $err)
    {
        throw new \PDOException("Error: " . $err->getMessage());
    }
}

function getClientes(\PDO $connect)
{
    try
    {
        $sql = "SELECT * FROM tb_cliente";
        $state = $connect->prepare($sql);
        $state->execute();
        $result = $state->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Nenhum cliente encontrado");
        return $result;
    } catch (\PDOException $err)
    {
        throw new \PDOException("Error: " . $err->getMessage());
    }
}