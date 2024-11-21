<?php


use controllers\usuarioController\UsuarioController;
use controllers\jogadorController\JogadorController;
use models\Usuario;

use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadorByEmail;
use function controllers\usuarioController\getClienteByEmail;

include("../connection/connect.php");
include("../repository/UsuarioRepository.php");
include("../services/UsuarioService.php");
include("../model/Usuario.php");
include("../model/Jogador.php");
include("../repository/JogadorRepository.php");
include("../services/JogadorService.php");
include("../controllers/usuarioController/usuarioController.php");
include("../controllers/jogadorController/jogadorController.php");
// inserir comandos acima para importar as funções necessárias
// como o arquivo de conexão e o arquivo de controller

function loginJogador(PDO $connect, string $email, string $senha)
{
    $result = getJogadorByEmail($connect, $email);
    if ($result)
    {
        if (password_verify($senha, $result['ds_senha']))
        {
            echo "Login efetuado com sucesso";
            session_start();
            session_regenerate_id(true);
            $_SESSION['initiated'] = true;
            $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

            $_SESSION['user_id'] = $result['cd_jog'];
            $_SESSION['user_name'] = $result['name_jog'];
            $_SESSION['user_email'] = $result['ds_email'];
            $_SESSION['type_login'] = "jogador";
            header("Location: ../home-jogador/home.php");
            exit() ;
        }
        else
        {
            header("Location: login.php?error=Senha incorreta");
        }
    }
}

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
        throw new \PDOException("Falha de conexão. Tente novamente mais tarde.");

    // Getting inputs from form
    // $email = $_POST['email'];
    $email = filter_input(INPUT_POST, 'usuario', FILTER_VALIDATE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);
    $type_login = filter_input(INPUT_POST, 'typelogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $email = "teste@hotmail.com";
    // $senha = "1234";

    if ($type_login == "usuario")
    {
        $client = new UsuarioController($connect);
        $client->loginUsuario($email, $senha);
        header("Location: ../home-usuario/home.php");
        // loginClient($connect, $email, $senha);
    }
    else if ($type_login == "jogador")
    {
        $jogador = new JogadorController($connect);
        $jogador->loginJogador($email, $senha);
        header("Location: ../home-jogador/home.php");
        // loginJogador($connect, $email, $senha);
    }
    else
    {
        header("Location: login.php?error=Tipo de login inválido");
    }

}
catch (\PDOException $err)
{
    // echo $err->getMessage();
    header("Location: login.php?error=". $err->getMessage());
}