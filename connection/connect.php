<?php
namespace Connection;



// informações para conexão no bd sebrae@123
$server = "localhost:3307";
$user = "root";
$password = "";
// $password = "sebrae@123";
$password = "@25859Eee";
$db = "db_anger";

// funções criadas para conexão com o BD

function connect_to_db_pdo(string $server, string $user, string $password, string $db)
{
    try {
        $connect = new \PDO("mysql:host=$server;dbname=$db", $user, $password);
        $connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $connect;
    } catch (\PDOException $err) {
        $echo = "Connection failed... " . $err->getMessage();
        return null;
    }
}

function connect_to_db_sqli($server, $user, $password, $db)
{
    echo "Connecting to database... <br>";
    $connect = new \mysqli($server, $user, $password, $db);
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
        return null;
    }
    echo "Connected successfully";
    return $connect;
}
