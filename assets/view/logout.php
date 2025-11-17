<?php
session_start();

// Guardar idioma antes de destruir sessão
$lang = $_SESSION['lang'] ?? 'pt-BR';

// Limpar todas as variáveis de sessão
$_SESSION = array();

// Destruir o cookie de sessão se existir
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir a sessão
session_destroy();

// Reiniciar sessão para manter idioma
session_start();
$_SESSION['lang'] = $lang;

// Redirecionar para login
header('Location: login.php?lang=' . $lang);
exit;
?>