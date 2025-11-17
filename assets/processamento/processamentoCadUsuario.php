<?php
session_start();
require_once 'funcoesBD.php';

// Verifica se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadastrarUsuario.php');
    exit;
}

// Receber dados do formulário
$nome = limparDados($_SESSION['user_name'] ?? '');
$email = limparDados($_SESSION['user_email'] ?? '');
$senha = $_SESSION['user_password'] ?? '';
$data_nascimento = $_SESSION['user_birth_date'] ?? '';
$genero_valor = $_SESSION['user_gender'] ?? '';

// Preferências de marketing
$marketing = isset($_POST['marketing']) ? 1 : 0;
$compartilhar_dados = isset($_POST['compartilharDados']) ? 1 : 0;
$aceitou_termos = isset($_POST['aceitarTermos']) ? 1 : 0;

// Idioma
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'pt-BR';

// Array para armazenar erros
$erros = [];

// Validações básicas
if (empty($email) || !validarEmail($email)) {
    $erros[] = 'Email inválido';
}

if (empty($senha)) {
    $erros[] = 'Senha não informada';
} elseif (strlen($senha) < 10) {
    $erros[] = 'Senha deve ter no mínimo 10 caracteres';
} elseif (!preg_match('/[a-zA-Z]/', $senha)) {
    $erros[] = 'Senha deve conter pelo menos 1 letra';
} elseif (!preg_match('/[0-9#?!&@$%^*()_+\-=\[\]{}|;:,.<>?]/', $senha)) {
    $erros[] = 'Senha deve conter pelo menos 1 número ou caractere especial';
}

if (empty($nome)) {
    $erros[] = 'Nome não informado';
} elseif (strlen($nome) > 50) {
    $erros[] = 'Nome muito longo (máximo 50 caracteres)';
}

if (empty($data_nascimento)) {
    $erros[] = 'Data de nascimento não informada';
}

if (empty($genero_valor)) {
    $erros[] = 'Gênero não informado';
}

if (!$aceitou_termos) {
    $erros[] = 'Você precisa aceitar os termos e condições';
}

// Se há erros, volta para a página anterior
if (!empty($erros)) {
    $_SESSION['cadastro_errors'] = $erros;
    header('Location: ../view/cadUsuarioTermos.php?lang=' . $lang);
    exit;
}

// Validar data de nascimento
$data_parts = explode('-', $data_nascimento);
if (count($data_parts) !== 3) {
    $_SESSION['cadastro_errors'] = array('Data de nascimento inválida');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

$ano = (int)$data_parts[0];
$mes = (int)$data_parts[1];
$dia = (int)$data_parts[2];

if (!checkdate($mes, $dia, $ano)) {
    $_SESSION['cadastro_errors'] = array('Data de nascimento inválida');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

// Verificar idade mínima (13 anos)
$hoje = new DateTime();
$nascimento = new DateTime($data_nascimento);
$idade = $hoje->diff($nascimento)->y;

if ($idade < 13) {
    $_SESSION['cadastro_errors'] = array('Você precisa ter pelo menos 13 anos para se cadastrar');
    header('Location: ../view/cadUsuarioInfos.php?lang=' . $lang);
    exit;
}

// Verificar Gênero
$generos_validos = array(
    'mulher' => 'Mulher',
    'homem' => 'Homem',
    'nao-binario' => 'Não binário',
    'outro' => 'Outro',
    'prefiro-nao-dizer' => 'Prefiro não dizer'
);
$genero_db = $generos_validos[$genero_valor] ?? 'Prefiro não dizer';

// Verificar se o email já existe
$usuario_existe = buscarUsuarioEmail($email);

if ($usuario_existe) {
    $_SESSION['cadastro_errors'] = array('Este email já está cadastrado');
    header('Location: ../view/cadastrarUsuario.php?lang=' . $lang);
    exit;
}

// Inserir usuário no banco de dados
$user_id = inserirUsuario($nome, $email, $senha, $data_nascimento, $genero_db);

if ($user_id) {
    // Limpar dados temporários da sessão
    unset($_SESSION['user_email']);
    unset($_SESSION['user_password']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_birth_date']);
    unset($_SESSION['user_gender']);
    unset($_SESSION['cadastro_errors']);
    
    // Criar sessão do usuário logado
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $nome;
    $_SESSION['user_email'] = $email;
    $_SESSION['userLoggedIn'] = true;
    $_SESSION['lang'] = $lang;
    
    // Redirecionar para página inicial
    header('Location: ../view/pagInicial.php?lang=' . $lang . '&success=cadastro');
    exit;
} else {
    $_SESSION['cadastro_errors'] = array('Erro ao processar cadastro. Tente novamente.');
    header('Location: ../view/cadUsuarioTermos.php?lang=' . $lang);
    exit;
}
?>