<?php
session_start();
require_once 'funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/formCadMusica.php');
    exit;
}

// Recebe forms
$artist_id = $_SESSION['artist_id'];
$titulo = limparDados($_POST['titulo'] ?? '');
$artista = limparDados($_POST['artista'] ?? '');
$album = limparDados($_POST['album'] ?? '');
$tipo = limparDados($_POST['tipo'] ?? '');
$genero_mus = limparDados($_POST['genero'] ?? '');
$ano = intval($_POST['ano'] ?? date('Y'));
$duracao = limparDados($_POST['duracao'] ?? '');
$letra = limparDados($_POST['letra'] ?? '');
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Verifica capa 
$capa_path = '';
$upload_dir_capa = '../uploads/capas_musicas/';

if (!file_exists($upload_dir_capa)) {
    mkdir($upload_dir_capa, 0777, true);
}

if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['capa']['tmp_name'];
    $file_size = $_FILES['capa']['size'];
    $file_ext = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));
    
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['musica_error'] = 'Formato de imagem não permitido';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
    
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['musica_error'] = 'Imagem muito grande (máximo 10MB)';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
    
    $novo_nome = 'capa_' . $artist_id . '_' . time() . '.' . $file_ext;
    $capa_path = $upload_dir_capa . $novo_nome;
    
    if (!move_uploaded_file($file_tmp, $capa_path)) {
        $_SESSION['musica_error'] = 'Erro ao fazer upload da capa';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
}

// Verifica audio
$audio_path = '';
$upload_dir_audio = '../uploads/audios/';

if (!file_exists($upload_dir_audio)) {
    mkdir($upload_dir_audio, 0777, true);
}

if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['audio']['tmp_name'];
    $file_size = $_FILES['audio']['size'];
    $file_ext = strtolower(pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION));
    
    $extensoes_permitidas = array('mp3', 'wav', 'flac');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['musica_error'] = 'Formato de áudio não permitido';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
    
    if ($file_size > 50 * 1024 * 1024) {
        $_SESSION['musica_error'] = 'Arquivo de áudio muito grande (máximo 50MB)';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
    
    $novo_nome = 'audio_' . $artist_id . '_' . time() . '.' . $file_ext;
    $audio_path = $upload_dir_audio . $novo_nome;
    
    if (!move_uploaded_file($file_tmp, $audio_path)) {
        $_SESSION['musica_error'] = 'Erro ao fazer upload do áudio';
        header('Location: ../view/formCadMusica.php?lang=' . $lang);
        exit;
    }
}

// Validações
$erros = array();

if (empty($titulo)) {
    $erros[] = 'Título é obrigatório';
}

if (empty($artista)) {
    $erros[] = 'Nome do artista é obrigatório';
}

if (empty($album)) {
    $erros[] = 'Álbum é obrigatório';
}

if (empty($tipo) || !in_array($tipo, array('Single', 'EP', 'Álbum'))) {
    $erros[] = 'Tipo inválido';
}

if (empty($audio_path)) {
    $erros[] = 'Arquivo de áudio é obrigatório';
}

if (!empty($erros)) {
    $_SESSION['musica_errors'] = $erros;
    header('Location: ../view/formCadMusica.php?lang=' . $lang);
    exit;
}

// Inserir musica no bd
$musica_id = inserirMusica(
    $artist_id, 
    $titulo, 
    $artista, 
    $album, 
    $tipo, 
    $genero_mus, 
    $ano, 
    $duracao, 
    $letra, 
    $audio_path, 
    $capa_path
);

if ($musica_id) {
    header('Location: ../view/dashboardArtDiscografia.php?lang=' . $lang . '&success=musica_cadastrada');
    exit;
} else {
    $_SESSION['musica_error'] = 'Erro ao processar cadastro. Tente novamente.';
    header('Location: ../view/formCadMusica.php?lang=' . $lang);
    exit;
}
?>