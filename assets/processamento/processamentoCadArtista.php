<?php
session_start();
require_once 'funcoesBD.php';

// Verificar se usuário está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Você precisa estar logado para cadastrar um artista';
    $_SESSION['redirect_after_login'] = 'cadastrarArtistaMusica.php';
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/formCadArtista.php');
    exit;
}

// Receber formulário
$user_id = $_SESSION['user_id'];
$nome_artistico = limparDados($_POST['nome'] ?? '');
$genero_art = limparDados($_POST['genero'] ?? '');
$biografia = limparDados($_POST['bio'] ?? '');
$instagram = limparDados($_POST['instagram'] ?? '');
$twitter = limparDados($_POST['twitter'] ?? '');
$tiktok = limparDados($_POST['tiktok'] ?? '');
$site = limparDados($_POST['website'] ?? '');
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Array para armazenar erros
$erros = array();

// Validações
if (empty($nome_artistico)) {
    $erros[] = 'Nome artístico é obrigatório';
} else {
    // Verificar se nome artístico já existe
    if (verificarNomeArtisticoExiste($nome_artistico)) {
        $erros[] = 'Este nome artístico já está em uso. Por favor, escolha outro';
    }
    
    // Validar comprimento
    if (mb_strlen($nome_artistico) < 2) {
        $erros[] = 'Nome artístico deve ter pelo menos 2 caracteres';
    }
    
    if (mb_strlen($nome_artistico) > 50) {
        $erros[] = 'Nome artístico deve ter no máximo 50 caracteres';
    }
}

// Validar biografia
if (!empty($biografia) && mb_strlen($biografia) > 1000) {
    $erros[] = 'Biografia deve ter no máximo 1000 caracteres';
}

// Validar Instagram (obrigatório)
if (empty($instagram)) {
    $erros[] = 'Instagram é obrigatório';
} else if (!filter_var($instagram, FILTER_VALIDATE_URL)) {
    $erros[] = 'URL do Instagram inválida. Use o formato: https://instagram.com/usuario';
}

// Validar Twitter (opcional)
if (!empty($twitter) && !filter_var($twitter, FILTER_VALIDATE_URL)) {
    $erros[] = 'URL do Twitter inválida. Use o formato: https://x.com/usuario';
}

// Validar TikTok (opcional)
if (!empty($tiktok) && !filter_var($tiktok, FILTER_VALIDATE_URL)) {
    $erros[] = 'URL do TikTok inválida. Use o formato: https://tiktok.com/@usuario';
}

// Validar Website (opcional)
if (!empty($site) && !filter_var($site, FILTER_VALIDATE_URL)) {
    $erros[] = 'URL do Website inválida. Use o formato: https://seusite.com';
}

// Verifica se já existe perfil de artista
$artista_existe = buscarArtistaPorUsuario($user_id);

if ($artista_existe) {
    $erros[] = 'Você já possui um perfil de artista cadastrado';
}

// Processar upload de capa
$capa_path = '';
$upload_dir = '../uploads/capas_artistas/';

// Criar diretório se não existir
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Verificar se há arquivo de capa
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
        // Gerar nome único para o arquivo
        $novo_nome = 'artista_' . $user_id . '_' . time() . '.' . $file_ext;
        $capa_path = $upload_dir . $novo_nome;
        
        // Mover arquivo para o diretório de uploads
        if (!move_uploaded_file($file_tmp, $capa_path)) {
            $erros[] = 'Erro ao fazer upload da imagem. Tente novamente';
        }
    }
} else if (isset($_FILES['capa']) && $_FILES['capa']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Tratar outros erros de upload
    switch ($_FILES['capa']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $erros[] = 'Arquivo muito grande';
            break;
        case UPLOAD_ERR_PARTIAL:
            $erros[] = 'Upload incompleto. Tente novamente';
            break;
        default:
            $erros[] = 'Erro no upload da imagem';
            break;
    }
}

// Se houver erros, retornar para o formulário
if (!empty($erros)) {
    $_SESSION['artista_errors'] = $erros;
    $_SESSION['form_data'] = $_POST;
    header('Location: ../view/formCadArtista.php?lang=' . $lang);
    exit;
}

// Inserir no banco de dados
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
    
    // Limpar dados do formulário
    unset($_SESSION['form_data']);
    unset($_SESSION['artista_errors']);
    
    // Mensagem de sucesso
    $_SESSION['success_message'] = 'Perfil de artista criado com sucesso! Bem-vindo ao Giana Station for Artists.';
    
    // Redirecionar para dashboard de artista
    header('Location: ../view/dashboardArtista.php?lang=' . $lang);
    exit;
} else {
    // Erro ao inserir no banco
    $_SESSION['artista_errors'] = array('Erro ao processar cadastro. Tente novamente em alguns instantes.');
    $_SESSION['form_data'] = $_POST;
    header('Location: ../view/formCadArtista.php?lang=' . $lang);
    exit;
}
?>