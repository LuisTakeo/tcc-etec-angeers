<?php
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadorByEmail;
use function controllers\usuarioController\getClienteByEmail;

include("../connection/connect.php");
include("../controllers/usuarioController/usuarioController.php");
include("../controllers/jogadorController/jogadorController.php");
// inserir comandos acima para importar as funções necessárias
// como o arquivo de conexão e o arquivo de controller

function loginClient(PDO $connect, string $email, string $senha)
{
    $result = getClienteByEmail($connect, $email);
    if ($result)
    {
        if (password_verify($senha, $result['ds_senha']))
        {
            echo "Login efetuado com sucesso";
            session_start();
            session_regenerate_id(true);
            $_SESSION['initiated'] = true;
            $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);


            $_SESSION['user_id'] = $result['cd_cli'];
            $_SESSION['user_name'] = $result['name_cli'];
            $_SESSION['user_email'] = $result['ds_email'];
            $_SESSION['type_login'] = "usuario";

            header("Location: ../home-usuario/home.php");
            exit() ;
        }
        else
        {
            header("Location: login.php?error=Senha incorreta");
        }
    }
}

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
        throw new \PDOException("Connection failed");

    // Getting inputs from form
    // $email = $_POST['email'];
    $email = filter_input(INPUT_POST, 'usuario', FILTER_VALIDATE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);
    $type_login = filter_input(INPUT_POST, 'typelogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $email = "teste@hotmail.com";
    // $senha = "1234";

    if ($type_login == "usuario")
    {
        loginClient($connect, $email, $senha);
    }
    else if ($type_login == "jogador")
    {
        loginJogador($connect, $email, $senha);
    }
    else
    {
        header("Location: login.php?error=Tipo de login inválido");
    }

}
catch (\PDOException $err)
{
    echo "Error: " . $err->getMessage();
    header("Location: login.php?error=Não encontrado");
}