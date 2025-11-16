<?php
require_once 'config.php';
$pageTitle = translate('sign_up');
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-cadHomeUsuario.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('sign_up'); ?> | Giana Station</title>
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
            <img src="../img/GA-Station.png" alt="Giana Station">
            <h1><?php echo translate('sign_up_title'); ?></h1>
        </section>

        <form method="POST" action="cadUsuarioSenha.php">
            <section class="form-grupo">
                <label for="email"><?php echo translate('email_address'); ?></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    placeholder="<?php echo translate('email_placeholder'); ?>"
                    pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                    required>
            </section>

            <a href="#" class="telefone"><?php echo translate('use_phone'); ?></a>

            <button type="submit" class="btn-avancar" id="cadSenha">
                <?php echo translate('advance'); ?>
            </button> 

            <div class="linha2"></div>

            <section class="btn-conectar-space">
                <button type="button" class="btn-conectar" id="btnGoogle">
                    <img src="../img/logo-google.png" alt="Google">
                    <?php echo translate('sign_up_google'); ?>
                </button>
                
                <button type="button" class="btn-conectar" id="btnApple">
                    <img src="../img/apple-logo.png" alt="Apple">
                    <?php echo translate('sign_up_apple'); ?>
                </button>
            </section>
        </form>

        <section class="singin-link">
            <p><?php echo translate('already_have_account'); ?></p>
            <p>
                <a href="login.php?lang=<?php echo $currentLang; ?>">
                    <?php echo translate('enter'); ?>
                </a>
            </p>
        </section>
    </section>

    <footer>
        <section class="rodape">
            <p><?php echo translate('recaptcha_text'); ?></p>
        </section>
    </footer>
    
    <?php require_once 'languageModal.php'; ?>

    <script>
        document.getElementById('singup').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            if (!email || !email.includes('@')) {
                e.preventDefault();
                alert('<?php echo translate('invalid_email'); ?>');
            }
        });

        document.getElementById('btnGoogle').addEventListener('click', function() {
            console.log('Cadastro com Google');
            alert('<?php echo translate('under_development'); ?>');
        });

        document.getElementById('btnApple').addEventListener('click', function() {
            console.log('Cadastro com Apple');
            alert('<?php echo translate('under_development'); ?>');
        });

        document.querySelector('.telefone').addEventListener('click', function(e) {
            e.preventDefault();
            alert('<?php echo translate('under_development'); ?>');
        });
    </script>
</body>
</html>