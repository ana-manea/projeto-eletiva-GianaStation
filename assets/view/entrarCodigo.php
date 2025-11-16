<?php
require_once 'config.php';

if (isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?lang=' . $currentLang . '&error=invalid_email');
        exit();
    }
} elseif (isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?lang=' . $currentLang . '&error=invalid_email');
        exit();
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
            <a href="login.php?lang=<?php echo $currentLang; ?>">
                <img src="../img/back.png" alt="<?php echo translate('back'); ?>">
            </a>
        </section>

        <form method="POST" action="../processamento/processamento.php">
            <h1 class="titulo">
                <?php echo translate('verification_code_title'); ?> <?php echo $emailMascarado; ?>
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
            
            input.addEventListener('input', function(e) {
             
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });

            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            input.addEventListener('focus', function() {
                this.select();
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text');
                const digits = pastedData.replace(/\D/g, '').split('');
                
                digits.forEach((digit, i) => {
                    if (inputs[i]) {
                        inputs[i].value = digit;
                    }
                });
                
                const lastFilledIndex = Math.min(digits.length - 1, inputs.length - 1);
                if (digits.length >= inputs.length) {
                    inputs[inputs.length - 1].focus();
                } else if (inputs[lastFilledIndex + 1]) {
                    inputs[lastFilledIndex + 1].focus();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            inputs.forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        
                        const allFilled = Array.from(inputs).every(inp => inp.value.length === 1);
                        if (allFilled) {
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>