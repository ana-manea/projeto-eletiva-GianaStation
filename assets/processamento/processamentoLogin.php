<?php
session_start();
require_once '../processamento/funcoesBD.php';

// Verifica se já está conectado
if (isset($_SESSION['user_id'])) {
    $lang = $_SESSION['lang'] ?? 'pt-BR';
    
    // Se for artista, redirecionar para dashboard
    if (isset($_SESSION['is_artist']) && $_SESSION['is_artist']) {
        header('Location: ../view/dashboardArtista.php?lang=' . $lang);
    } else {
        header('Location: ../view/pagInicial.php?lang=' . $lang);
    }
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

$_SESSION['lang'] = $lang;

// Validações básicas
if (empty($email) || empty($senha)) {
    $_SESSION['login_error'] = 'E-mail e senha são obrigatórios';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

if (!validarEmail($email)) {
    $_SESSION['login_error'] = 'E-mail inválido';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Buscar usuário no banco
$usuario = buscarUsuarioEmail($email);

if (!$usuario) {
    $_SESSION['login_error'] = 'E-mail não cadastrado';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Verificar senha (texto plano)
// NOTA: Em produção, use password_hash() e password_verify()
if ($senha !== $usuario['Senha']) {
    $_SESSION['login_error'] = 'Senha incorreta';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

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
unset($_SESSION['login_error']);

// Verificar se há uma página de redirecionamento após login
if (isset($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
    
    // Se for artista e tentou acessar página de cadastro, redirecionar para dashboard
    if ($artista && $redirect === 'cadastrarArtistaMusica.php') {
        header('Location: ../view/dashboardArtista.php?lang=' . $lang);
        exit;
    }
    
    header('Location: ../view/' . $redirect . '?lang=' . $lang);
    exit;
}

// Redirecionar baseado no tipo de usuário
if ($artista) {
    header('Location: ../view/dashboardArtista.php?lang=' . $lang);
} else {
    header('Location: ../view/pagInicial.php?lang=' . $lang);
}
exit;
?>