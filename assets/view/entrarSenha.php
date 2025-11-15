<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
} else {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-entrar.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title>Entrar com senha | Giana Station</title>
</head>
<body>
    <section class="conteudo">
        <section class="top">
            <a href="login.php">
                <img src="../img/back.png" alt="Voltar">
            </a>
        </section>
        
        <form method="POST" action="../processamento/processamento.php">
            <h1 class="titulo">Entrar com senha</h1>

            <section class="inputSpace">
                <label for="email-login">E-mail ou nome de usuário</label>
                <input 
                type="text" 
                name="email" 
                id="email-login" 
                class="inputSenha" 
                value="<?php echo $email; ?>" 
                readonly>
            </section>

            <section class="inputSpace">
                <label for="senha-login">Senha</label>
                <input 
                type="password" 
                name="senha" 
                id="senha-login" 
                class="inputSenha" 
                placeholder="Senha"
                minlength="10"
                pattern="^(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':|,.<>\/?])(?=.*[a-zA-Z]).{10,}$"
                required 
                autofocus>
            </section>
            
            <input type="submit" value="Entrar">
        </form>
        
        <a href="entrarCodigo.php?email=<?php echo urlencode($email); ?>" class="linkCodigo">
            <p>Entrar sem senha</p>
        </a>
    </section>

    <footer class="footerSenha">
        <p>Este site é protegido pelo reCAPTCHA e está sujeito à <a href="#">Política de Privacidade</a> e aos <a href="#">Termos de Serviço</a> do Google.</p>
    </footer>
</body>
</html>