<?php
session_start();
require_once '../processamento/funcoesBD.php';

// Verificar se está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/perfilUsuario.php');
    exit;
}

$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';
$user_id = $_SESSION['user_id'];
$nome = limparDados($_POST['nome_usuario'] ?? '');

// Validar nome
if (empty($nome)) {
    $_SESSION['erro_perfil'] = 'Nome é obrigatório';
    header('Location: ../view/perfilUsuario.php?lang=' . $lang);
    exit;
}

$foto_perfil = null;

if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $arquivo = $_FILES['foto_perfil'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extensao, $extensoes_permitidas)) {
        $diretorio = '../uploads/fotos_perfil/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        
        $nome_arquivo = 'perfil_' . $user_id . '_' . time() . '.' . $extensao;
        $caminho_completo = $diretorio . $nome_arquivo;
        
        if (move_uploaded_file($arquivo['tmp_name'], $caminho_completo)) {
            $foto_perfil = $caminho_completo;
        }
    }
}

// Atualizar no banco
$resultado = atualizarUsuario($user_id, $nome, $foto_perfil);

if ($resultado) {
    // Atualizar sessão
    $_SESSION['user_name'] = $nome;
    $_SESSION['sucesso_perfil'] = 'Perfil atualizado com sucesso!';
} else {
    $_SESSION['erro_perfil'] = 'Erro ao atualizar perfil';
}

header('Location: ../view/perfilUsuario.php?lang=' . $lang);
exit;
?>