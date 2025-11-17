<?php
session_start();
require_once '../processamento/funcoesBD.php';

// Verifica se está conectado
if (isset($_SESSION['user_id'])) {
    header('Location: ../view/pagInicial.php');
    exit;
}

// Verifica se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/login.php');
    exit;
}

// Dados do formulário
$email = limparDados($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

$erros = array();

// Validações básicas
if (empty($email)) {
    $erros[] = 'E-mail é obrigatório';
} else if (!validarEmail($email)) {
    $erros[] = 'E-mail inválido';
}

if (empty($senha)) {
    $erros[] = 'Senha é obrigatória';
}

// Se houver erros de validação, retornar
if (!empty($erros)) {
    $_SESSION['login_errors'] = $erros;
    $_SESSION['login_email'] = $email;
    header('Location: ../view/login.php?lang=' . $lang);
    exit;
}

$usuario = validarLogin($email, $senha);

if ($usuario) {
    // Login bem-sucedido
    $_SESSION['user_id'] = $usuario['ID_Usuario'];
    $_SESSION['user_name'] = $usuario['Nome'];
    $_SESSION['user_email'] = $usuario['Email'];
    $_SESSION['userLoggedIn'] = true;
    
    // Verificar se é artista
    $artista = buscarArtistaPorUsuario($usuario['ID_Usuario']);
    
    if ($artista) {
        $_SESSION['is_artist'] = true;
        $_SESSION['artist_id'] = $artista['ID_Artista'];
        $_SESSION['artist_name'] = $artista['Nome_artistico'];
    }
    
    // Limpar erros
    unset($_SESSION['login_errors']);
    unset($_SESSION['login_email']);
    
    // Mensagem de sucesso
    $_SESSION['success_message'] = 'Bem-vindo de volta, ' . $usuario['Nome'] . '!';
    
    // Redirecionar
    if (isset($_SESSION['redirect_after_login'])) {
        $redirect = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        header('Location: ' . $redirect);
    } else {
        header('Location: ../view/pagInicial.php?lang=' . $lang);
    }
    exit;
} else {
    // Login falhou
    $_SESSION['login_errors'] = array('E-mail ou senha incorretos');
    $_SESSION['login_email'] = $email;
    header('Location: ../view/login.php?lang=' . $lang);
    exit;
}