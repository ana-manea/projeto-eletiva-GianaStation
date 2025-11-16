<?php
require_once 'config.php';
$pageTitle = translate('terms_conditions');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome']) && isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['ano']) && isset($_POST['genero'])) {
        $_SESSION['user_name'] = trim($_POST['nome']);
        
        $dia = str_pad($_POST['dia'], 2, '0', STR_PAD_LEFT);
        $mes = str_pad($_POST['mes'], 2, '0', STR_PAD_LEFT);
        $ano = $_POST['ano'];
        $_SESSION['user_birth_date'] = "$ano-$mes-$dia";
        
        $_SESSION['user_gender'] = $_POST['genero'];
    }
}

if (empty($_SESSION['user_email']) || empty($_SESSION['user_password']) || 
    empty($_SESSION['user_name']) || empty($_SESSION['user_birth_date']) || 
    empty($_SESSION['user_gender'])) {
    header('Location: cadastrarUsuario.php?lang=' . $currentLang);
    exit;
}

$modalConfig = [
    'returnUrl' => 'cadUsuarioTermos.php',
    'preserveParams' => ['email']
];
?>
<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-cadUsuarioTermos.css">
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

        <form method="POST" action="../processamento/processamento.php" id="formTermos"> 
            <section class="etapa">
                <button type="button" class="btn-voltar" id="returnInfo">
                    <img src="../img/return.png" alt="<?php echo translate('back'); ?>">
                </button>
                <section class="etapa-conteudo">
                    <p class="info-etapa"><?php echo translate('step_3_of_3'); ?></p>
                    <h1><?php echo translate('terms_conditions'); ?></h1>
                </section>
            </section>

            <section class="checkbox-grupo">
                <label for="marketing" class="opcao-checkbox">
                    <input type="checkbox" id="marketing" name="marketing">
                    <span><?php echo translate('no_marketing'); ?></span>
                </label>

                <label for="compartilharDados" class="opcao-checkbox">
                    <input type="checkbox" name="compartilharDados" id="compartilharDados">
                    <span><?php echo translate('share_data'); ?></span>
                </label>

                <label for="aceitarTermos" class="opcao-checkbox">
                    <input type="checkbox" name="aceitarTermos" id="aceitarTermos">
                    <span>
                        <?php echo translate('agree_terms'); ?>
                        <a href="#" class="link-destaque"><?php echo translate('terms_conditions_link'); ?></a>
                    </span>
                </label>
            </section>

            <section class="aviso-privacidade">
                <p>
                    <?php echo translate('privacy_notice'); ?>
                    <a href="#" class="link-destaque"><?php echo translate('privacy_policy'); ?></a>
                </p>
            </section>

            <button type="submit" class="btn-avancar" id="submitBtn" disabled>
                <?php echo translate('sign_up_button'); ?>
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
        document.getElementById('returnInfo').addEventListener('click', function() {
            window.location.href = 'cadUsuarioInfos.php?lang=<?php echo $currentLang; ?>';
        });

        const formTermos = document.getElementById('formTermos');
        const submitBtn = document.getElementById('submitBtn');
        const aceitarTermos = document.getElementById('aceitarTermos');

        aceitarTermos.addEventListener('change', () => {
            submitBtn.disabled = !aceitarTermos.checked;
        });

        formTermos.addEventListener('submit', function(e) {
            if (!aceitarTermos.checked) {
                e.preventDefault();
                alert('<?php echo translate('agree_terms'); ?>');
                return;
            }
            
            const dadosUsuario = {
                marketing: document.getElementById('marketing').checked,
                compartilharDados: document.getElementById('compartilharDados').checked,
                aceitarTermos: aceitarTermos.checked
            };
            
            console.log('Dados do usuário:', dadosUsuario);
        });
    </script>
</body>
</html>