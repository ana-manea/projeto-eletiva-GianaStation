<?php
session_start();
require_once '../processamento/funcoesBD.php';

// Verifica se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/login.php');
    exit;
}

// Dados do formulário
$email = limparDados($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Validações básicas
if (empty($email) || empty($senha)) {
    $_SESSION['login_error'] = 'Preencha todos os campos';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Validar formato de email
if (!validarEmail($email)) {
    $_SESSION['login_error'] = 'Email inválido';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Buscar usuário no banco de dados
$usuario = buscarUsuarioEmail($email);

// Verificar se usuário existe
if (!$usuario) {
    $_SESSION['login_error'] = 'Email ou senha incorretos';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Verificar senha
if ($senha !== $usuario['Senha']) {
    $_SESSION['login_error'] = 'Email ou senha incorretos';
    header('Location: ../view/entrarSenha.php?email=' . urlencode($email) . '&lang=' . $lang);
    exit;
}

// Login bem-sucedido - inicia sessão
$_SESSION['user_id'] = $usuario['ID_Usuario'];
$_SESSION['user_name'] = $usuario['Nome'];
$_SESSION['user_email'] = $usuario['Email'];
$_SESSION['userLoggedIn'] = true;
$_SESSION['lang'] = $lang;

// Limpar mensagens de erro
unset($_SESSION['login_error']);

// Verificar se usuário é artista
$artista = buscarArtistaPorUsuario($usuario['ID_Usuario']);

if ($artista) {
    $_SESSION['is_artist'] = true;
    $_SESSION['artist_id'] = $artista['ID_Artista'];
    $_SESSION['artist_name'] = $artista['Nome_artistico'];
}

// Redirecionar para página inicial
header('Location: ../view/pagInicial.php?lang=' . $lang . '&success=login');
exit;
?>