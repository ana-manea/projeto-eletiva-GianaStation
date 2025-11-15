<?php
if (isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    $emailMascarado = substr($email, 0, 2) . str_repeat('*', 8) . substr($email, strpos($email, '@'));
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
    <title>Código de verificação | Giana Station</title>
</head>
<body>

    <section class="conteudo">
        <section class="top">
            <a href="login.php">
                <img src="../img/back.png">
            </a>
        </section>

        <form method="POST" action="../processamento/processamento.php">
            <h1 class="titulo">Insira o código de 6 dígitos enviado para <?php echo $emailMascarado; ?></h1>
            
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            
            <section class="codigo_btns">
                <input type="text" name="cod1" id="cod1" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod2" id="cod2" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod3" id="cod3" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod4" id="cod4" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod5" id="cod5" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod6" id="cod6" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </section>
            
            <input type="submit" value="Entrar">
        </form>

        <form method="POST" action="../processamento/reenviarCodigo.php" style="margin-top: -20px;">
            <input 
            type="hidden" 
            name="email" 
            value="<?php echo $email; ?>">
            
            <button type="submit" id="reenviar_btn">Reenviar Código</button>
        </form>
        
        <a href="entrarSenha.php" class="linkSenha">
            <p>Entrar com senha</p>
        </a>
    </section>

    <footer>
        <p>© 2025 Giana Station AB</p>
    </footer>
</body>
</html>