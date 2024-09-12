<?php
// Inicia a sessão
session_start();

// Limpa o array $_SESSION para remover todos os dados da sessão
$_SESSION = array();

// Verifica se o cookie de sessão existe e o destrói
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

header("Location: home.php");