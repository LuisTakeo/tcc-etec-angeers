<?php
namespace controllers\servicosController;

function getServicos(\PDO $connect)
{
    try
    {
        $sql = "SELECT * FROM tb_servico";
        $state = $connect->prepare($sql);
        $state->execute();
        $result = $state->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new \PDOException("Nenhum serviço encontrado");
        return $result;
    } catch (\PDOException $err)
    {
        echo "Error: " . $err->getMessage();
    }
}