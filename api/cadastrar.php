<?php

use controllers\jogadorController\JogadorController;
use controllers\usuarioController\UsuarioController;
use models\Jogador;
use models\Usuario;

use function Connection\connect_to_db_pdo;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite requisições de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeçalhos HTTP permitidos
header('Cache-Control: no-cache, no-store, must-revalidate'); // Controle de cache
header('X-Content-Type-Options: nosniff'); // Previne ataques de MIME type sniffing
header('X-Frame-Options: DENY'); // Protege contra ataques de clickjacking
header('X-XSS-Protection: 1; mode=block'); // Ativa a proteção contra ataques de XSS

include_once("./includes.php");

    // Conectando ao banco de dados

try
{

    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
    throw new \PDOException("Connection failed");

    // Getting inputs from form
    // $name = $_POST['nome'];
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
    if ($type == 'jogador') {
        $rank = filter_input(INPUT_POST, 'Elo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    } else {
        $rank = NULL;
    }


    $date = new \DateTime();
    $timestamp = $date->format('Y-m-d H:i:s');
    // echo $timestamp;

    if (!$name || !$password || !$phone || !$email || !$cpf)
    {
        throw new \Exception("Dados de entrada inválidos");
    }
    if ($type == 'jogador' && !$rank) {
        throw new \Exception("Dados de entrada inválidos");
    }
    if ($type == 'jogador')
    {
        $jogadorController = new JogadorController($connect);
        $jogadorNovo = new Jogador(
            NULL,
            $name,
            password_hash($password, PASSWORD_DEFAULT),
            $phone,
            $email,
            $cpf, true, $timestamp, $timestamp, $rank);

            // Cadastrando o jogador
            $jogadorController->cadastrarApi($jogadorNovo);

    }
    else if ($type == 'cliente')
    {
        $usuarioController = new UsuarioController($connect);
        $usuarioNovo = new Usuario(
            NULL,
            $name,
            password_hash($password, PASSWORD_DEFAULT),
            $phone,
            $email,
            $cpf, true, $timestamp, $timestamp);

            // Cadastrando o cliente
            $usuarioController->cadastrarApi($usuarioNovo);
    }

    // Criando um novo jogador


}
catch (Exception $err)
{
    echo json_encode(array("message" => "Erro ao cadastrar jogador: " . $err->getMessage()));
}