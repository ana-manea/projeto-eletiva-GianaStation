<?php
session_start();
require_once 'funcoesBD.php';

// Verificar se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadPlaylist.php');
    exit;
}

// Receber dados do forms
$user_id = $_SESSION['user_id'];
$nome_playlist = limparDados($_POST['Nome_playlist'] ?? '');
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Verifica capa
$capa_path = null;
$upload_dir = '../uploads/capas_playlists/';

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_FILES['Capa_play_path']) && $_FILES['Capa_play_path']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['Capa_play_path']['tmp_name'];
    $file_size = $_FILES['Capa_play_path']['size'];
    $file_ext = strtolower(pathinfo($_FILES['Capa_play_path']['name'], PATHINFO_EXTENSION));
    
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['playlist_error'] = 'Formato de imagem não permitido';
        header('Location: ../view/cadPlaylist.php?lang=' . $lang);
        exit;
    }
    
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['playlist_error'] = 'Imagem muito grande (máximo 10MB)';
        header('Location: ../view/cadPlaylist.php?lang=' . $lang);
        exit;
    }
    
    $novo_nome = 'playlist_' . $user_id . '_' . time() . '.' . $file_ext;
    $capa_path = $upload_dir . $novo_nome;
    
    if (!move_uploaded_file($file_tmp, $capa_path)) {
        $_SESSION['playlist_error'] = 'Erro ao fazer upload da imagem';
        header('Location: ../view/cadPlaylist.php?lang=' . $lang);
        exit;
    }
}

// Validações
if (empty($nome_playlist)) {
    $_SESSION['playlist_error'] = 'Nome da playlist é obrigatório';
    header('Location: ../view/cadPlaylist.php?lang=' . $lang);
    exit;
}

// Cria playlist no bd
$playlist_id = criarPlaylist($user_id, $nome_playlist, $capa_path);

if ($playlist_id) {
    header('Location: ../view/pagInicial.php?lang=' . $lang . '&success=playlist_criada');
    exit;
} else {
    $_SESSION['playlist_error'] = 'Erro ao criar playlist. Tente novamente.';
    header('Location: ../view/cadPlaylist.php?lang=' . $lang);
    exit;
}
?>