<?php
namespace controllers\servicosController;

function getServicos(\PDO $connect)
{

    $sql = "SELECT * FROM tb_servico";
    $state = $connect->prepare($sql);
    $state->execute();
    $result = $state->fetchAll(\PDO::FETCH_ASSOC);
    if (!$result)
        throw new \PDOException("Nenhum serviço encontrado");
    return $result;

}

function getServico(\PDO $connect, int $id)
{
    $sql = "SELECT * FROM tb_servico WHERE cd_serv = :id";
    $state = $connect->prepare($sql);
    $state->bindParam(":id", $id);
    $state->execute();
    $result = $state->fetch(\PDO::FETCH_ASSOC);
    if (!$result)
        throw new \PDOException("Nenhum serviço encontrado");
    return $result;
}