<?php
namespace testes;

use controllers\usuarioController\UsuarioController;
use Exception;
use models\Jogador;
use models\Usuario;
use repository\JogadorRepository;
use repository\UsuarioRepository;
use services\JogadorService;
use services\UsuarioService;

use function Connection\connect_to_db_pdo;
// use PHPUnit\Framework\TestCase;

require '../repository/UsuarioRepository.php';
require '../services/UsuarioService.php';
require '../controllers/usuarioController/UsuarioController.php';
require '../model/Usuario.php';
require '../model/Jogador.php';
require '../connection/connect.php';
require '../repository/JogadorRepository.php';
require '../services/JogadorService.php';

try
{
    $connect = connect_to_db_pdo($server, $user, $password, $db);
    if (!$connect)
        throw new \PDOException("Connection failed");

    $jogador = new Jogador(1, "John Doe", "password123", "123456789", "email@email.com", "12345678901", true, "2023-01-01", "2023-01-02", "Ouro");
    $jogadorService = new JogadorService(new JogadorRepository($connect));
    $consulta = $jogadorService->getJogadorByEmail("luis1@email.com");
    var_dump($consulta);
    // $userRepo = new UsuarioRepository($connect);
    // var_dump($userRepo);
    // $hashedpass = password_hash("password123", PASSWORD_DEFAULT);
    // $novoUsuario = new Usuario(1, "John Doe", $hashedpass, "123456789", "joo@example.com", "12345678901", true, "2023-01-01", "2023-01-02");

    // $userService = new UsuarioService($userRepo);
    // $userController = new UsuarioController($connect);
    // // $result = $userController->getClienteByEmailToApi("teste@hotmail.com");
    // $userController->getClientes();
    // var_dump($result);
    // $userRepo->create($novoUsuario);
    // $user = $userRepo->getCliente(1);
    // $users = $userRepo->getClientes();
    // $userByEmail = $userRepo->getClienteByEmail("joo@example.com");
    // var_dump($user);
    // var_dump($users);
    // var_dump($userByEmail);
    // $jogador = new Jogador(1, "John Doe", $hashedpass, "123456789", "joo@example.com", "12345678901", true, "2023-01-01", "2023-01-02", "Ouro");
    // var_dump($jogador->toArray());
}
catch (Exception $err)
{
    echo $err->getMessage();
}


// class Testes extends TestCase
// {
//     public function testUsuarioCreation()
//     {
//         $usuario = new Usuario(1, "John Doe", "password123", "123456789", "john@example.com", "12345678901", true, "2023-01-01", null);

//         $this->assertEquals(1, $usuario->getId());
//         $this->assertEquals("John Doe", $usuario->getName());
//         $this->assertEquals("password123", $usuario->getSenha());
//         $this->assertEquals("123456789", $usuario->getTel());
//         $this->assertEquals("john@example.com", $usuario->getEmail());
//         $this->assertEquals("12345678901", $usuario->getCpf());
//         $this->assertTrue($usuario->getAtivo());
//         $this->assertEquals("2023-01-01", $usuario->getDataInclusao());
//         $this->assertNull($usuario->getDataExclusao());
//     }

//     public function testUsuarioGettersAndSetters()
//     {
//         $usuario = new Usuario(1, "John Doe", "password123", "123456789", "john@example.com", "12345678901", true, "2023-01-01", null);

//         $usuario->setId(2);
//         $usuario->setName("Jane Doe");
//         $usuario->setSenha("password456");
//         $usuario->setTel("987654321");
//         $usuario->setEmail("jane@example.com");
//         $usuario->setCpf("98765432109");
//         $usuario->setAtivo(false);
//         $usuario->setDataInclusao("2023-01-02");
//         $usuario->setDataExclusao("2023-01-03");

//         $this->assertEquals(2, $usuario->getId());
//         $this->assertEquals("Jane Doe", $usuario->getName());
//         $this->assertEquals("password456", $usuario->getSenha());
//         $this->assertEquals("987654321", $usuario->getTel());
//         $this->assertEquals("jane@example.com", $usuario->getEmail());
//         $this->assertEquals("98765432109", $usuario->getCpf());
//         $this->assertFalse($usuario->getAtivo());
//         $this->assertEquals("2023-01-02", $usuario->getDataInclusao());
//         $this->assertEquals("2023-01-03", $usuario->getDataExclusao());

//     }
// }

// $novoUsuario = new Usuario(1, "John Doe", "password123", "123456789", "john@example.com", "12345678901", true, "2023-01-01", null);

// var_dump($novoUsuario);