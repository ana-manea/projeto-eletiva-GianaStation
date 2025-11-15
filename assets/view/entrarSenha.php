<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);

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
                    type="text" 
                    name="email" 
                    id="email-login" 
                    class="inputSenha" 
                    value="<?php echo $email; ?>" 
                    readonly>
            </section>

            <section class="inputSpace">
                <label for="senha-login"><?php echo translate('password'); ?></label>
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
    ?>

    <div id="languageModal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
        <div style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); margin: 5% auto; padding: 2rem; border: 1px solid rgba(213, 24, 238, 0.3); border-radius: 16px; width: 90%; max-width: 500px; box-shadow: 0 8px 32px rgba(213, 24, 238, 0.3); position: relative;">
            <button onclick="toggleLanguageModal()" style="position: absolute; right: 1rem; top: 1rem; background: transparent; border: none; color: rgba(255, 255, 255, 0.6); font-size: 1.5rem; cursor: pointer;">✕</button>
            
            <h2 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem; text-align: center; font-weight: 600;">Selecione o idioma / Select language</h2>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($availableLanguages as $code => $lang): ?>
                    <a href="#" 
                       onclick="changeLangAndSubmit('<?php echo $code; ?>'); return false;"
                       style="background: <?php echo $code === $currentLang ? 'linear-gradient(135deg, #d518ee 0%, #e88bf5 100%)' : 'rgba(255, 255, 255, 0.05)'; ?>; color: white; border: 1px solid <?php echo $code === $currentLang ? '#d518ee' : 'rgba(255, 255, 255, 0.1)'; ?>; padding: 1rem 1.25rem; border-radius: 8px; font-size: 1rem; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: space-between;">
                        <span><?php echo $lang['name']; ?></span>
                        <?php if ($code === $currentLang): ?>
                            <span style="color: white;">✓</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleLanguageModal() {
            const modal = document.getElementById('languageModal');
            modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
        }

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

        window.onclick = function(event) {
            const modal = document.getElementById('languageModal');
            if (event.target === modal) {
                toggleLanguageModal();
            }
        }
    </script>
</body>
</html>