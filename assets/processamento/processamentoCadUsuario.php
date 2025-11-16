<?php
session_start();
require_once 'funcoesBD.php';

// Verifica se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadastrarUsuario.php');
    exit;
}

// Receber dados do forms
$nome = limparDados($_POST['nome'] ?? '');
$dia = limparDados($_POST['dia'] ?? '');
$mes = limparDados($_POST['mes'] ?? '');
$ano = limparDados($_POST['ano'] ?? '');
$genero = limparDados($_POST['genero'] ?? '');

// Dados da sessão (email e senha das páginas anteriores)
$email = $_SESSION['user_email'] ?? '';
$password = $_SESSION['user_password'] ?? '';

// Idioma
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Validações
$erros = [];

if (empty($email) || !validarEmail($email)) {
    $erros[] = 'Email inválido';
}

if (empty($password)) {
    $erros[] = 'Senha não informada';
}

if (empty($nome)) {
    $erros[] = 'Nome não informado';
}

if (empty($dia) || empty($mes) || empty($ano)) {
    $erros[] = 'Data de nascimento incompleta';
}

if (empty($genero)) {
    $erros[] = 'Gênero não informado';
}

// Se tem erros, volta para a página anterior
if (!empty($erros)) {
    $_SESSION['cadastro_errors'] = $erros;
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

$data_nascimento = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);

// Valida data
if (!checkdate($mes, $dia, $ano)) {
    $_SESSION['cadastro_errors'] = array('Data de nascimento inválida');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

// Verifica idade mínima
$hoje = new DateTime();
$nascimento = new DateTime($data_nascimento);
$idade = $hoje->diff($nascimento)->y;

if ($idade < 13) {
    $_SESSION['cadastro_errors'] = array('Você precisa ter pelo menos 13 anos');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

// Verifica o gÊnero
$generos_validos = array(
    'mulher' => 'Mulher',
    'homem' => 'Homem',
    'nao-binario' => 'Não binário',
    'outro' => 'Outro',
    'prefiro-nao-dizer' => 'Prefiro não dizer'
);
$genero_db = $generos_validos[$genero] ?? 'Prefiro não dizer';

// Verifica se o email existe
$usuario_existe = buscarUsuarioEmail($email);

if ($usuario_existe) {
    $_SESSION['cadastro_errors'] = array('Este email já está cadastrado');
    header('Location: ../view/cadastrarUsuario.php?lang=' . $lang);
    exit;
}

// Inserir no BD
$user_id = inserirUsuario($nome, $email, $password, $data_nascimento, $genero_db);

if ($user_id) {
    unset($_SESSION['user_email']);
    unset($_SESSION['user_password']);
    
    // Criar sessão
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $nome;
    $_SESSION['user_email'] = $email;
    $_SESSION['userLoggedIn'] = true;
    
    // Redireciona para página inicial
    header('Location: ../view/pagInicial.php?lang=' . $lang . '&success=cadastro');
    exit;
} else {
    $_SESSION['cadastro_errors'] = array('Erro ao processar cadastro. Tente novamente.');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}
?>