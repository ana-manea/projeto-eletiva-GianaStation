<?php
require_once 'config.php';

if (isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    if (isset($_POST['lang'])) {
        $_SESSION['lang'] = $_POST['lang'];
        $currentLang = $_POST['lang'];
    }
} elseif (isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
        $currentLang = $_GET['lang'];
    }
} else {
    header('Location: login.php?lang=' . $currentLang);
    exit();
}

$emailMascarado = substr($email, 0, 2) . str_repeat('*', 8) . substr($email, strpos($email, '@'));
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-entrar.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('verification_code_title'); ?> | Giana Station</title>
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
            <a href="index.php?lang=<?php echo $currentLang; ?>">
                <img src="../img/back.png" alt="<?php echo translate('back'); ?>">
            </a>
        </section>

        <form method="POST" action="../processamento/processamento.php">
            <h1 class="titulo">
                <?php echo translate('verification_code_title') . ' ' . $emailMascarado; ?>
            </h1>
            
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <section class="codigo_btns">
                <input type="text" name="cod1" id="cod1" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                <input type="text" name="cod2" id="cod2" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod3" id="cod3" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod4" id="cod4" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod5" id="cod5" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="cod6" id="cod6" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </section>
            
            <input type="submit" value="<?php echo translate('sign_in'); ?>">
        </form>

        <form method="POST" action="../processamento/reenviarCodigo.php" style="margin-top: -20px;">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <button type="submit" id="reenviar_btn"><?php echo translate('resend_code'); ?></button>
        </form>
        
        <form method="POST" action="entrarSenha.php" style="margin-top: 10px;">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            <button type="submit" class="linkSenha" style="background: none; border: none; color: inherit; cursor: pointer; padding: 0;">
                <p><?php echo translate('login_with_password'); ?></p>
            </button>
        </form>
    </section>

    <footer>
        <p><?php echo translate('copyright'); ?></p>
    </footer>

    <?php
    $modalConfig = [
        'returnUrl' => 'entrarCodigo.php',
        'preserveParams' => ['email']
    ];
    require_once 'languageModal.php';
    ?>

    <script>
        const inputs = document.querySelectorAll('.codigo_btns input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>