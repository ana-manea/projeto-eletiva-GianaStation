<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?lang=' . $currentLang . '&error=invalid_email');
        exit();
    }

    if (isset($_POST['lang'])) {
        $_SESSION['lang'] = $_POST['lang'];
        $currentLang = $_POST['lang'];
    }
} else {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-entrar.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('login_password_title'); ?> | Giana Station</title>
</head>
<body>
    <?php
    $buttonConfig = [
        'position' => 'absolute',
        'showText' => true,
        'style' => ''
    ];
    require_once 'languageBtn.php';
    ?>

    <section class="conteudo">
        <section class="top">
            <a href="login.php?lang=<?php echo $currentLang; ?>">
                <img src="../img/back.png" alt="<?php echo translate('back'); ?>">
            </a>
        </section>
        
        <form method="POST" action="../processamento/processamento.php">
            <h1 class="titulo"><?php echo translate('login_password_title'); ?></h1>

            <section class="inputSpace">
                <label for="email-login"><?php echo translate('email_username'); ?></label>
                <input 
                    type="email" 
                    name="email" 
                    id="email-login" 
                    class="inputSenha" 
                    value="<?php echo $email; ?>" 
                    readonly>
            </section>

            <section class="inputSpace">
                <label for="senha-login"><?php echo translate('password'); ?></label>
                <section class="botao-senha">
                    <input 
                        type="password" 
                        name="senha" 
                        id="senha-login" 
                        class="inputSenha" 
                        placeholder="<?php echo translate('password_placeholder'); ?>"
                        minlength="10"
                        pattern="^(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':|,.<>\/?])(?=.*[a-zA-Z]).{10,}$"
                        required 
                        autofocus>
                    <button type="button" class="visualizacao-senha" id="visualizacaoSenha">
                        <img id="verSenha" src="../img/esconder.png" alt="<?php echo translate('hide_password'); ?>">
                        <img id="esconderSenha" src="../img/ver.png" style="display: none;" alt="<?php echo translate('show_password'); ?>">
                    </button>
                </section>
            </section>
            
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            <input type="submit" value="<?php echo translate('sign_in'); ?>">
        </form>
        
        <form method="POST" action="entrarCodigo.php" style="margin-top: 10px;">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            <button type="submit" class="linkCodigo" style="background: none; border: none; color: inherit; cursor: pointer; padding: 0;">
                <p><?php echo translate('login_no_password'); ?></p>
            </button>
        </form>
    </section>

    <footer class="footerSenha">
        <p><?php echo translate('recaptcha_text'); ?></p>
    </footer>

    <?php
    $modalConfig = [
        'returnUrl' => 'entrarSenha.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    ?>

    <script>
        const passwordInput = document.getElementById('senha-login');
        const visualizacaoSenha = document.getElementById('visualizacaoSenha');
        const verSenha = document.getElementById('verSenha');
        const esconderSenha = document.getElementById('esconderSenha');
        
        let mostrarSenha = false;

        visualizacaoSenha.addEventListener('click', () => {
            mostrarSenha = !mostrarSenha;
            passwordInput.type = mostrarSenha ? 'text' : 'password';
            verSenha.style.display = mostrarSenha ? 'none' : 'block';
            esconderSenha.style.display = mostrarSenha ? 'block' : 'none';
        });

        function changeLangAndSubmit(lang) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'entrarSenha.php';
            
            const emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email';
            emailInput.value = '<?php echo $email; ?>';
            
            const langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'lang';
            langInput.value = lang;
            
            form.appendChild(emailInput);
            form.appendChild(langInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>