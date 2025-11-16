<?php
require_once 'config.php';
$pageTitle = translate('create_password');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $_SESSION['user_email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
}

if (empty($_SESSION['user_email'])) {
    header('Location: cadastrarUsuario.php?lang=' . $currentLang);
    exit;
}

$modalConfig = [
    'returnUrl' => 'cadUsuarioSenha.php',
    'preserveParams' => ['email']
];
?>
<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-cadUsuarioSenha.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('sign_up'); ?> | Giana Station</title>
</head>
<body>
    <section class="conteudo">
        <section class="cabecalho"> 
            <img src="../img/GA-Station.png" alt="Giana Station">
        </section>

        <section class="barra-progresso"> 
            <div class="porcentagem"></div>
        </section>

        <form method="POST" action="cadUsuarioInfos.php?lang=<?php echo $currentLang; ?>" id="formSenha"> 
            <section class="etapa">
                <button type="button" class="btn-voltar" id="returnCad">
                    <img src="../img/return.png" alt="<?php echo translate('back'); ?>">
                </button>
                <section class="etapa-conteudo">
                    <p class="info-etapa"><?php echo translate('step_1_of_3'); ?></p>
                    <h1><?php echo translate('create_password'); ?></h1>
                </section>
            </section>
            
            <section class="form-grupo"> 
                <label for="password"><?php echo translate('password'); ?></label>
                <section class="botao-senha"> 
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="visualizacao-senha" id="visualizacaoSenha"> 
                        <img id="verSenha" src="../img/esconder.png" alt="<?php echo translate('hide_password'); ?>"> 
                        <img id="esconderSenha" src="../img/ver.png" style="display: none;" alt="<?php echo translate('show_password'); ?>">
                    </button>
                </section>
            </section>

            <section class="requerimentos">
                <p><?php echo translate('password_must_have'); ?></p>
                <section class="item-requerimento">
                    <span class="requiremento-check" id="checkLetra">✓</span>
                    <span><?php echo translate('one_letter'); ?></span>
                </section>

                <section class="item-requerimento">
                    <span class="requiremento-check" id="checkEspecial">✓</span>
                    <span><?php echo translate('one_number_special'); ?></span>
                </section>

                <section class="item-requerimento">
                    <span class="requiremento-check" id="checkTamanho">✓</span>
                    <span><?php echo translate('ten_characters'); ?></span>
                </section>
            </section>
            
            <button type="submit" class="btn-avancar" id="submitBtn" disabled>
                <?php echo translate('advance'); ?>
            </button>
        </form>
    </section>

    <footer>
        <section class="rodape">
            <p><?php echo translate('recaptcha_text'); ?></p>
        </section>
    </footer>
    
    <?php require_once 'languageModal.php'; ?>

    <script>
        document.getElementById('returnCad').addEventListener('click', function() {
            window.location.href = 'cadastrarUsuario.php?lang=<?php echo $currentLang; ?>';
        });

        const passwordInput = document.getElementById('password');
        const visualizacaoSenha = document.getElementById('visualizacaoSenha');
        const verSenha = document.getElementById('verSenha');
        const esconderSenha = document.getElementById('esconderSenha');
        const submitBtn = document.getElementById('submitBtn');
        const checkLetra = document.getElementById('checkLetra');
        const checkEspecial = document.getElementById('checkEspecial');
        const checkTamanho = document.getElementById('checkTamanho');
        
        let mostrarSenha = false;

        visualizacaoSenha.addEventListener('click', () => {
            mostrarSenha = !mostrarSenha;
            passwordInput.type = mostrarSenha ? 'text' : 'password';
            verSenha.style.display = mostrarSenha ? 'none' : 'block';
            esconderSenha.style.display = mostrarSenha ? 'block' : 'none';
        });

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;

            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumberOrSpecial = /[0-9#?!&@$%^*()_+\-=[\]{}|;:,.<>?]/.test(password);
            const hasMinLength = password.length >= 10;

            checkLetra.classList.toggle('valid', hasLetter);
            checkEspecial.classList.toggle('valid', hasNumberOrSpecial);
            checkTamanho.classList.toggle('valid', hasMinLength);

            const isValid = hasLetter && hasNumberOrSpecial && hasMinLength;
            submitBtn.disabled = !isValid;
        });

        document.getElementById('formSenha').addEventListener('submit', (e) => {
            const password = passwordInput.value;
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumberOrSpecial = /[0-9#?!&@$%^*()_+\-=[\]{}|;:,.<>?]/.test(password);
            const hasMinLength = password.length >= 10;
            
            if (!hasLetter || !hasNumberOrSpecial || !hasMinLength) {
                e.preventDefault();
                alert('<?php echo translate('password_must_have'); ?>');
            }
        });
    </script>
</body>
</html>