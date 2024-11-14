<?php
namespace services;

use repository\UsuarioRepository;
use models\Usuario;
use models\Restricao;

class UsuarioService
{
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function createUsuario(Usuario $new_client)
    {
        try
        {
            $this->usuarioRepository->beginTransaction();
            $this->usuarioRepository->create($new_client);
            $this->usuarioRepository->commit();
            return "Usuário criado com sucesso";
        }
        catch (\PDOException $err)
        {
            $this->usuarioRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }

    public function getClienteById($id)
    {
        $cliente = $this->usuarioRepository->getCliente($id);
        return $cliente;
    }

    public function getClienteByEmail($email)
    {
        $cliente = $this->usuarioRepository->getClienteByEmail($email);
        return $cliente;
    }

    public function getClientes()
    {
        $clientes = $this->usuarioRepository->getClientes();
        return $clientes;
    }

    public function loginClient($email, $senha)
    {
        $cliente = $this->usuarioRepository->getClienteByEmail($email);
        if ($cliente && password_verify($senha, $cliente->getSenha()))
            return $cliente;
        throw new \PDOException("Email ou senha inválidos");
    }

    public function createRestricao($id_cliente, $id_jogador)
    {
        try
        {
            // verificar primeiro se já existe a restricao
            $restricao = $this->usuarioRepository->getRestricaoUsuario($id_cliente);
            if ($restricao && array_search($id_jogador, $restricao->getIdJogador()))
                throw new \PDOException("Jogador já restrito");
            $restricao = new Restricao(null, $id_cliente, $id_jogador, null);
            $this->usuarioRepository->beginTransaction();
            $this->usuarioRepository->createRestricao($restricao);
            $this->usuarioRepository->commit();
            return "Restrição criada com sucesso";
        }
        catch (\PDOException $err)
        {
            $this->usuarioRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }
}