<?php
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\cadastrarJogador;

include("../connection/connect.php");
include("../controllers/jogadorController/jogadorController.php");
// inserir comandos acima para importar as funções necessárias
// como o arquivo de conexão e o arquivo de controller

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
        throw new \PDOException("Connection failed");

    // Getting inputs from form
    // $name = $_POST['nome'];
    $name = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    // $password = $_POST['senha'];
    $password = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);
    // $phone = $_POST['telefone'];
    $phone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
    // $email = $_POST['email'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    // $cpf = $_POST['cpf'];
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
    $rank = filter_input(INPUT_POST, 'Elo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $date = new \DateTime();
    $timestamp = $date->format('Y-m-d H:i:s');
    // echo $timestamp;

    $new_jogador = [
        "name" => $name,
        "senha" => password_hash($password, PASSWORD_DEFAULT),
        "tel" => $phone,
        "email" => $email,
        "cpf" => $cpf,
        "rank" => $rank,
        "jogador_ativo" => true,
        "data_inclusao" => $timestamp,
        "data_exclusao" => $timestamp
    ];
    var_dump($new_jogador);
    cadastrarJogador($connect, $new_jogador);
    // usar password_hash para criptografar a senha e password_verify para verificar a senha
    // password_hash cria um hash de senha usando um algoritmo de hash forte e irreversível
    // password_verify verifica se a senha corresponde ao hash
    header("Location: ../login/login.php");
            exit() ;
}
catch (\PDOException $err)
{
    $errorMsg = urlencode($err->getMessage());
    header("Location: jogador.php?error=" . $errorMsg);
}
