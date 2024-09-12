<?php

session_set_cookie_params([
    'lifetime' => 0, // ou um valor específico para a expiração
    'secure' => true, // true para enviar o cookie apenas sobre HTTPS
    'httponly' => true, // true para tornar o cookie inacessível via JavaScript
    'samesite' => 'Strict' // Strict ou Lax para controle de solicitações entre sites
]);

session_start();

// Regeneração de ID de Sessão
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Verificação do Agente do Usuário
if (!isset($_SESSION['HTTP_USER_AGENT'])) {
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
} else {
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
        // Diferença detectada, possível sequestro de sessão
        session_destroy();
        session_start();
    }
}

// Configuração de Cookies Seguros


// Verifica se o usuário está logado