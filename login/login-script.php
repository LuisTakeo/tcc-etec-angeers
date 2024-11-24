<?php

include("./includes.php");

use controllers\usuarioController\UsuarioController;
use controllers\jogadorController\JogadorController;
use models\Usuario;

use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadorByEmail;
use function controllers\usuarioController\getClienteByEmail;



function try_to_login($server, $user, $password, $db)
{

    try
    {
        $connect = connect_to_db_pdo($server, $user, $password, $db);
        if (!$connect)
            throw new \PDOException("Falha de conexão. Tente novamente mais tarde.");


        $email = filter_input(INPUT_POST, 'usuario', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);
        $type_login = filter_input(INPUT_POST, 'typelogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($type_login == "usuario")
        {
            $client = new UsuarioController($connect);
            $client->loginUsuario($email, $senha);
            header("Location: ../home-usuario/home.php");
        }
        else if ($type_login == "jogador")
        {
            $jogador = new JogadorController($connect);
            $jogador->loginJogador($email, $senha);
            header("Location: ../home-jogador/home.php");
        }
        else
            throw new PDOException("Tipo de login inválido");

    }
    catch (\PDOException $err)
    {
        // echo $err->getMessage();
        header("Location: login.php?error=". $err->getMessage());
    }
}

try_to_login($server, $user, $password, $db);