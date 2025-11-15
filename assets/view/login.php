<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('sign_in'); ?> | Giana Station</title>
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
        <section class="cabecalho">
            <img src="../img/GA-Station.png" alt="Logo Giana Station">
            <h1><?php echo translate('login_title'); ?></h1>
        </section>

        <section class="conectar-btn">
            <button>
                <img src="../img/logo-google.png" alt="Google">
                <?php echo translate('continue_google'); ?>
            </button>

            <button>
                <img src="../img/logo-facebook-cicle.png" alt="Facebook">
                <?php echo translate('continue_facebook'); ?>
            </button>

            <button>
                <img src="../img/apple-logo.png" alt="Apple">
                <?php echo translate('continue_apple'); ?>
            </button>

            <button type="button"><?php echo translate('continue_phone'); ?></button>
        </section>

        <div class="linha"></div>

        <form method="POST" action="entrarSenha.php">
            <label for="email-login"><?php echo translate('email_username'); ?></label>
            <input 
                type="text" 
                name="email" 
                id="email-login" 
                placeholder="<?php echo translate('email_username_placeholder'); ?>"
                required>
            
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            <input type="submit" id="entrar-senha" value="<?php echo translate('continue'); ?>">
        </form>

        <p class="linkCadastrar">
            <?php echo translate('no_account'); ?>
            <a href="cadastrarUsuario.php?lang=<?php echo $currentLang; ?>">
                <?php echo translate('sign_up'); ?>
            </a>
        </p>
    </section>

    <footer>
        <p><?php echo translate('recaptcha_text'); ?></p>
    </footer>
    
    <?php
    $modalConfig = [
        'returnUrl' => 'login.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    ?>
</body>
</html>