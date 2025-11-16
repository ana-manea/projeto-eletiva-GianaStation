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
    header('Location: ../view/formCadArtista.php');
    exit;
}

// Receber forms
$user_id = $_SESSION['user_id'];
$nome_artistico = limparDados($_POST['nome_artistico'] ?? '');
$genero_art = limparDados($_POST['genero'] ?? '');
$biografia = limparDados($_POST['biografia'] ?? '');
$instagram = limparDados($_POST['instagram'] ?? '');
$twitter = limparDados($_POST['twitter'] ?? '');
$tiktok = limparDados($_POST['tiktok'] ?? '');
$site = limparDados($_POST['site'] ?? '');
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// recebe as capas
$capa_path = '';
$upload_dir = '../uploads/capas_artistas/';

// Cria diretório se não existir
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Verifica se há arquivo de capa
if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['capa']['tmp_name'];
    $file_size = $_FILES['capa']['size'];
    $file_ext = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));
    
    // Validar extensão
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['artista_error'] = 'Formato de imagem não permitido';
        header('Location: ../view/formCadArtista.php?lang=' . $lang);
        exit;
    }
    
    // Validar tamanho (10MB)
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['artista_error'] = 'Imagem muito grande (máximo 10MB)';
        header('Location: ../view/formCadArtista.php?lang=' . $lang);
        exit;
    }
    
    // Gerar nome único para o arquivo
    $novo_nome = 'artista_' . $user_id . '_' . time() . '.' . $file_ext;
    $capa_path = $upload_dir . $novo_nome;
    
    // Mover arquivo para o diretório de uploads
    if (!move_uploaded_file($file_tmp, $capa_path)) {
        $_SESSION['artista_error'] = 'Erro ao fazer upload da imagem';
        header('Location: ../view/formCadArtista.php?lang=' . $lang);
        exit;
    }
}

// Validações
if (empty($nome_artistico)) {
    $_SESSION['artista_error'] = 'Nome artístico é obrigatório';
    header('Location: ../view/formCadArtista.php?lang=' . $lang);
    exit;
}

// Verifica se foi criado o perfil de artista
$artista_existe = buscarArtistaPorUsuario($user_id);

if ($artista_existe) {
    $_SESSION['artista_error'] = 'Você já possui um perfil de artista';
    header('Location: ../view/dashboardArtista.php?lang=' . $lang);
    exit;
}

// Inserir no bd
$artist_id = inserirArtista(
    $user_id, 
    $nome_artistico, 
    $capa_path, 
    $genero_art, 
    $biografia, 
    $instagram, 
    $twitter, 
    $tiktok, 
    $site
);

if ($artist_id) {
    // Atualizar sessão
    $_SESSION['is_artist'] = true;
    $_SESSION['artist_id'] = $artist_id;
    $_SESSION['artist_name'] = $nome_artistico;
    
    // Redirecionar para dashboard
    header('Location: ../view/dashboardArtista.php?lang=' . $lang . '&success=artista_cadastrado');
    exit;
} else {
    $_SESSION['artista_error'] = 'Erro ao processar cadastro. Tente novamente.';
    header('Location: ../view/formCadArtista.php?lang=' . $lang);
    exit;
}
?>