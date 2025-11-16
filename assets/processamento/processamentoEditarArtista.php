<?php
session_start();
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/dashboardArtPerfil.php');
    exit;
}

// Receber dados do formulário
$artist_id = $_SESSION['artist_id'];
$nome_artistico = limparDados($_POST['nome_artistico'] ?? '');
$biografia = limparDados($_POST['biografia'] ?? '');
$genero_art = limparDados($_POST['generos'] ?? '');
$instagram = limparDados($_POST['instagram'] ?? '');
$twitter = limparDados($_POST['twitter'] ?? '');
$tiktok = limparDados($_POST['tiktok'] ?? '');
$site = limparDados($_POST['site'] ?? '');
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Variáveis para armazenar paths de uploads
$foto_perfil_path = null;
$capa_path = null;

// Processar upload de foto de perfil (avatar)
$upload_dir_foto = '../uploads/fotos_artistas/';

if (!file_exists($upload_dir_foto)) {
    mkdir($upload_dir_foto, 0777, true);
}

if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['foto_perfil']['tmp_name'];
    $file_size = $_FILES['foto_perfil']['size'];
    $file_ext = strtolower(pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION));
    
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['artista_error'] = 'Formato de imagem não permitido';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
    
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['artista_error'] = 'Imagem muito grande (máximo 10MB)';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
    
    $novo_nome = 'foto_artista_' . $artist_id . '_' . time() . '.' . $file_ext;
    $foto_perfil_path = $upload_dir_foto . $novo_nome;
    
    if (!move_uploaded_file($file_tmp, $foto_perfil_path)) {
        $_SESSION['artista_error'] = 'Erro ao fazer upload da foto';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
}

// Processar upload de capa
$upload_dir_capa = '../uploads/capas_artistas/';

if (!file_exists($upload_dir_capa)) {
    mkdir($upload_dir_capa, 0777, true);
}

if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['capa']['tmp_name'];
    $file_size = $_FILES['capa']['size'];
    $file_ext = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));
    
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['artista_error'] = 'Formato de imagem não permitido';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
    
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['artista_error'] = 'Imagem muito grande (máximo 10MB)';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
    
    $novo_nome = 'capa_artista_' . $artist_id . '_' . time() . '.' . $file_ext;
    $capa_path = $upload_dir_capa . $novo_nome;
    
    if (!move_uploaded_file($file_tmp, $capa_path)) {
        $_SESSION['artista_error'] = 'Erro ao fazer upload da capa';
        header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
        exit;
    }
}

// Validações
if (empty($nome_artistico)) {
    $_SESSION['artista_error'] = 'Nome artístico não pode estar vazio';
    header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
    exit;
}

// Atualizar artista no banco de dados
$resultado = atualizarArtista($artist_id, $nome_artistico, $biografia, $genero_art, $instagram, $twitter, $tiktok, $site, $foto_perfil_path, $capa_path);

if ($resultado) {
    // Atualizar nome na sessão
    $_SESSION['artist_name'] = $nome_artistico;
    
    // Redirecionar com mensagem de sucesso
    header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang . '&success=perfil_atualizado');
    exit;
} else {
    $_SESSION['artista_error'] = 'Erro ao atualizar perfil. Tente novamente.';
    header('Location: ../view/dashboardArtPerfil.php?lang=' . $lang);
    exit;
}
?>