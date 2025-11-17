<?php
session_start();
require_once 'funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    $_SESSION['error_message'] = 'Você precisa ter um perfil de artista para cadastrar músicas';
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/formCadMusica.php');
    exit;
}

// Recebe formulário
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

// Array para armazenar erros
$erros = array();

// Validações básicas
if (empty($titulo)) {
    $erros[] = 'Título da música é obrigatório';
} else {
    if (mb_strlen($titulo) < 1) {
        $erros[] = 'Título deve ter pelo menos 1 caractere';
    }
    if (mb_strlen($titulo) > 200) {
        $erros[] = 'Título deve ter no máximo 200 caracteres';
    }
}

if (empty($artista)) {
    $erros[] = 'Nome do artista é obrigatório';
} else if (mb_strlen($artista) > 200) {
    $erros[] = 'Nome do artista deve ter no máximo 200 caracteres';
}

if (empty($album)) {
    $erros[] = 'Nome do álbum é obrigatório';
} else if (mb_strlen($album) > 200) {
    $erros[] = 'Nome do álbum deve ter no máximo 200 caracteres';
}

if (empty($tipo)) {
    $erros[] = 'Tipo é obrigatório';
} else if (!in_array($tipo, array('Single', 'EP', 'Álbum'))) {
    $erros[] = 'Tipo inválido. Escolha entre: Single, EP ou Álbum';
}

// Validar ano
if ($ano < 1900 || $ano > date('Y') + 1) {
    $erros[] = 'Ano inválido. Deve estar entre 1900 e ' . (date('Y') + 1);
}

// Validar duração (formato MM:SS)
if (!empty($duracao)) {
    if (!preg_match('/^\d{1,2}:\d{2}$/', $duracao)) {
        $erros[] = 'Formato de duração inválido. Use o formato MM:SS (exemplo: 3:45)';
    } else {
        // Validar valores
        list($min, $sec) = explode(':', $duracao);
        if ($sec >= 60) {
            $erros[] = 'Segundos devem ser menores que 60';
        }
    }
}

// Verificar se música já existe
if (!empty($titulo) && !empty($artista) && !empty($album)) {
    if (verificarMusicaExiste($titulo, $artista, $album)) {
        $erros[] = 'Esta música já está cadastrada neste álbum';
    }
}

// Processar upload de áudio (obrigatório)
$audio_path = '';
$upload_dir_audio = '../uploads/audios/';

if (!file_exists($upload_dir_audio)) {
    mkdir($upload_dir_audio, 0777, true);
}

if (!isset($_FILES['audio']) || $_FILES['audio']['error'] === UPLOAD_ERR_NO_FILE) {
    $erros[] = 'Arquivo de áudio é obrigatório';
} else if ($_FILES['audio']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['audio']['tmp_name'];
    $file_size = $_FILES['audio']['size'];
    $file_name = $_FILES['audio']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validar extensão
    $extensoes_permitidas = array('mp3', 'wav', 'flac', 'm4a');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $erros[] = 'Formato de áudio não permitido. Use: MP3, WAV, FLAC ou M4A';
    }
    
    // Validar tamanho (50MB)
    if ($file_size > 50 * 1024 * 1024) {
        $erros[] = 'Arquivo de áudio muito grande. Tamanho máximo: 50MB';
    }
    
    // Se não houver erros, fazer upload
    if (empty($erros)) {
        $novo_nome = 'audio_' . $artist_id . '_' . time() . '.' . $file_ext;
        $audio_path = $upload_dir_audio . $novo_nome;
        
        if (!move_uploaded_file($file_tmp, $audio_path)) {
            $erros[] = 'Erro ao fazer upload do áudio. Tente novamente';
        }
    }
} else {
    // Tratar outros erros de upload
    switch ($_FILES['audio']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $erros[] = 'Arquivo de áudio muito grande';
            break;
        case UPLOAD_ERR_PARTIAL:
            $erros[] = 'Upload de áudio incompleto. Tente novamente';
            break;
        default:
            $erros[] = 'Erro no upload do áudio';
            break;
    }
}

// Processar upload de capa (opcional)
$capa_path = '';
$upload_dir_capa = '../uploads/capas_musicas/';

if (!file_exists($upload_dir_capa)) {
    mkdir($upload_dir_capa, 0777, true);
}

if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['capa']['tmp_name'];
    $file_size = $_FILES['capa']['size'];
    $file_name = $_FILES['capa']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validar extensão
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $erros[] = 'Formato de imagem não permitido. Use: JPG, JPEG, PNG, GIF ou WEBP';
    }
    
    // Validar tamanho (10MB)
    if ($file_size > 10 * 1024 * 1024) {
        $erros[] = 'Imagem muito grande. Tamanho máximo: 10MB';
    }
    
    // Validar se é realmente uma imagem
    $check = getimagesize($file_tmp);
    if ($check === false) {
        $erros[] = 'O arquivo enviado não é uma imagem válida';
    }
    
    // Se não houver erros, fazer upload
    if (empty($erros)) {
        $novo_nome = 'capa_' . $artist_id . '_' . time() . '.' . $file_ext;
        $capa_path = $upload_dir_capa . $novo_nome;
        
        if (!move_uploaded_file($file_tmp, $capa_path)) {
            $erros[] = 'Erro ao fazer upload da capa. Tente novamente';
        }
    }
} else if (isset($_FILES['capa']) && $_FILES['capa']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Tratar outros erros de upload
    switch ($_FILES['capa']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $erros[] = 'Arquivo de imagem muito grande';
            break;
        case UPLOAD_ERR_PARTIAL:
            $erros[] = 'Upload de imagem incompleto. Tente novamente';
            break;
        default:
            $erros[] = 'Erro no upload da imagem';
            break;
    }
}

// Se houver erros, retornar para o formulário
if (!empty($erros)) {
    $_SESSION['musica_errors'] = $erros;
    $_SESSION['form_data'] = $_POST;
    header('Location: ../view/formCadMusica.php?lang=' . $lang);
    exit;
}

// Inserir música no banco de dados
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
    // Limpar dados do formulário
    unset($_SESSION['form_data']);
    unset($_SESSION['musica_errors']);
    
    // Mensagem de sucesso
    $_SESSION['success_message'] = 'Música cadastrada com sucesso!';
    
    // Redirecionar para dashboard (discografia)
    header('Location: ../view/dashboardArtDiscografia.php?lang=' . $lang);
    exit;
} else {
    // Erro ao inserir no banco
    $_SESSION['musica_errors'] = array('Erro ao processar cadastro. Tente novamente em alguns instantes.');
    $_SESSION['form_data'] = $_POST;
    header('Location: ../view/formCadMusica.php?lang=' . $lang);
    exit;
}
?>