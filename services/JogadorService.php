<?php
namespace services;

use models\Jogador;
use repository\JogadorRepository;

class JogadorService
{
    private $jogadorRepository;

    public function __construct(JogadorRepository $jogadorRepository)
    {
        $this->jogadorRepository = $jogadorRepository;
    }

    public function createJogador(Jogador $new_jogador)
    {
        try
        {
            $this->jogadorRepository->beginTransaction();
            $this->jogadorRepository->create($new_jogador);
            $this->jogadorRepository->commit();
            return "Jogador criado com sucesso";
        }
        catch (\PDOException $err)
        {
            $this->jogadorRepository->rollBack();
            throw new \PDOException($err->getMessage());
        }
    }

    public function getJogadorById($id)
    {
        $jogador = $this->jogadorRepository->getJogador($id);
        return $jogador;
    }

    public function getJogadorByEmail($email)
    {
        $jogador = $this->jogadorRepository->getJogadorByEmail($email);
        return $jogador;
    }

    public function getJogadores()
    {
        $jogadores = $this->jogadorRepository->getJogadores();
        return $jogadores;
    }

    public function loginJogador($email, $senha)
    {
        $jogador = $this->jogadorRepository->getJogadorByEmail($email);
        if ($jogador && password_verify($senha, $jogador->getSenha()))
            return $jogador;
        throw new \PDOException("Email ou senha inválidos");
    }
}