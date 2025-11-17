<?php
require_once 'config.php';

// Limpar dados temporários se estiver iniciando novo cadastro
if (!isset($_POST['email']) && !isset($_SESSION['returning_from_step'])) {
    unset($_SESSION['user_email']);
    unset($_SESSION['user_password']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_birth_date']);
    unset($_SESSION['user_gender']);
    unset($_SESSION['cadastro_errors']);
}

// Verificar erros
$errors = $_SESSION['cadastro_errors'] ?? [];
unset($_SESSION['cadastro_errors']);

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

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p style="margin: 5px 0;">⚠ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="cadUsuarioSenha.php" id="formCadastro">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <section class="form-grupo">
                <label for="email"><?php echo translate('email_address'); ?></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    class="<?php echo !empty($errors) ? 'input-error' : ''; ?>"
                    placeholder="<?php echo translate('email_placeholder'); ?>"
                    pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                    value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>"
                    required>
            </section>

            <a href="#" class="telefone"><?php echo translate('use_phone'); ?></a>

            <button type="submit" class="btn-avancar" id="btnAvancar">
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
    
    <?php 
    $modalConfig = [
        'returnUrl' => 'cadastrarUsuario.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php'; 
    ?>

    <script>
        const emailInput = document.getElementById('email');
        const formCadastro = document.getElementById('formCadastro');
        
        // Validação de email em tempo real
        emailInput.addEventListener('input', function() {
            const emailRegex = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            
            if (this.value && !emailRegex.test(this.value)) {
                this.setCustomValidity('<?php echo translate('invalid_email'); ?>');
            } else {
                this.setCustomValidity('');
            }
        });

        formCadastro.addEventListener('submit', function(e) {
            const email = emailInput.value.trim();
            const emailRegex = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            
            if (!email || !emailRegex.test(email)) {
                e.preventDefault();
                alert('<?php echo translate('invalid_email'); ?>');
                emailInput.focus();
            }
        });

        // Botões de cadastro social
        document.getElementById('btnGoogle').addEventListener('click', function() {
            alert('<?php echo translate('under_development'); ?>');
        });

        document.getElementById('btnApple').addEventListener('click', function() {
            alert('<?php echo translate('under_development'); ?>');
        });

        document.querySelector('.telefone').addEventListener('click', function(e) {
            e.preventDefault();
            alert('<?php echo translate('under_development'); ?>');
        });

        // Auto-focus no campo de email se houver erro
        <?php if (!empty($errors)): ?>
            emailInput.focus();
            emailInput.select();
        <?php endif; ?>
    </script>
</body>
</html>