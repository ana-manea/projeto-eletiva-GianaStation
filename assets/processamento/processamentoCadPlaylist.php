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
    header('Location: ../view/cadastrarPlaylist.php');
    exit;
}

// Receber dados do formulário
$user_id = $_SESSION['user_id'];
$nome_playlist = $_POST['Nome_playlist'] ?? '';
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Limpar dados
$nome_playlist = limparDados($nome_playlist);

// Validação do nome
if (empty($nome_playlist)) {
    $_SESSION['playlist_error'] = 'Nome da playlist é obrigatório';
    header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
    exit;
}

if (strlen($nome_playlist) > 50) {
    $_SESSION['playlist_error'] = 'Nome da playlist muito longo (máximo 50 caracteres)';
    header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
    exit;
}

// Verificar se já existe playlist com esse nome para o usuário
$conexao = conectarBD();
$nome_escaped = mysqli_real_escape_string($conexao, $nome_playlist);
$sql_check = "SELECT ID_Playlist FROM playlists WHERE FK_Usuario = $user_id AND Nome_playlist = '$nome_escaped'";
$resultado_check = mysqli_query($conexao, $sql_check);

if (mysqli_num_rows($resultado_check) > 0) {
    fecharConexao($conexao);
    $_SESSION['playlist_error'] = 'Você já possui uma playlist com este nome';
    header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
    exit;
}
fecharConexao($conexao);

// Processar capa da playlist
$capa_path = null;
$upload_dir = '../uploads/capas_playlists/';

// Criar diretório se não existir
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_FILES['Capa_play_path']) && $_FILES['Capa_play_path']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['Capa_play_path']['tmp_name'];
    $file_name = $_FILES['Capa_play_path']['name'];
    $file_size = $_FILES['Capa_play_path']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Extensões permitidas
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($file_ext, $extensoes_permitidas)) {
        $_SESSION['playlist_error'] = 'Formato de imagem não permitido. Use JPG, PNG ou GIF.';
        header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
        exit;
    }
    
    // Verificar tamanho (máximo 10MB)
    if ($file_size > 10 * 1024 * 1024) {
        $_SESSION['playlist_error'] = 'Imagem muito grande. O tamanho máximo é 10MB.';
        header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
        exit;
    }
    
    // Gerar nome único para o arquivo
    $novo_nome = 'playlist_' . $user_id . '_' . time() . '.' . $file_ext;
    $capa_path = $upload_dir . $novo_nome;
    
    // Fazer upload
    if (!move_uploaded_file($file_tmp, $capa_path)) {
        $_SESSION['playlist_error'] = 'Erro ao fazer upload da imagem. Tente novamente.';
        header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
        exit;
    }
}

// Criar playlist no banco de dados
$playlist_id = criarPlaylist($user_id, $nome_playlist, $capa_path);

if ($playlist_id) {
    // Sucesso - redirecionar para página inicial com mensagem de sucesso
    $_SESSION['playlist_success'] = 'Playlist criada com sucesso!';
    header('Location: ../view/pagInicial.php?lang=' . $lang);
    exit;
} else {
    // Erro ao criar playlist
    // Se fez upload da imagem, remover
    if ($capa_path && file_exists($capa_path)) {
        unlink($capa_path);
    }
    
    $_SESSION['playlist_error'] = 'Erro ao criar playlist. Tente novamente.';
    header('Location: ../view/cadastrarPlaylist.php?lang=' . $lang);
    exit;
}
?>