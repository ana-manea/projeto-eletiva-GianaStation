<?php
require_once 'config.php';
$pageTitle = translate('tell_about_you');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $_SESSION['user_password'] = $_POST['password'];
    $_SESSION['returning_from_step'] = true;
}

if (empty($_SESSION['user_email']) || empty($_SESSION['user_password'])) {
    header('Location: cadastrarUsuario.php?lang=' . $currentLang);
    exit;
}

$errors = $_SESSION['cadastro_errors'] ?? [];
unset($_SESSION['cadastro_errors']);

$modalConfig = [
    'returnUrl' => 'cadUsuarioInfos.php',
    'preserveParams' => []
];
?>
<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-cadUsuarioInfos.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo translate('sign_up'); ?> | Giana Station</title>
</head>
<body>
    <section class="conteudo">
        <section class="cabecalho"> 
            <img src="../img/GA-Station.png" alt="Giana Station">
        </section>

        <section class="barra-progresso"> 
            <div class="porcentagem" style="width: 66.66%;"></div>
        </section>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p style="margin: 5px 0;">⚠ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="cadUsuarioTermos.php" id="formInfo"> 
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <section class="etapa">
                <button type="button" class="btn-voltar" id="returnSenha">
                    <img src="../img/return.png" alt="<?php echo translate('back'); ?>">
                </button>
                <section class="etapa-conteudo">
                    <p class="info-etapa"><?php echo translate('step_2_of_3'); ?></p>
                    <h1><?php echo translate('tell_about_you'); ?></h1>
                </section>
            </section>

            <section class="form-grupo">
                <label for="nome"><?php echo translate('name'); ?></label>
                <p class="descricao"><?php echo translate('name_appears_profile'); ?></p>
                <input 
                    type="text" 
                    id="nome" 
                    name="nome"
                    class="<?php echo !empty($errors) ? 'input-error' : ''; ?>"
                    value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>"
                    maxlength="50"
                    required>
            </section>

            <section class="form-grupo">
                <label for="dataNascimento"><?php echo translate('birth_date'); ?></label>
                <p class="descricao">
                    <?php echo translate('why_need_birth_date'); ?>
                    <a href="#" class="link-info"><?php echo translate('learn_more'); ?></a>
                </p>
                <section class="data-nascimento">
                    <input 
                        type="text" 
                        id="dia" 
                        name="dia" 
                        placeholder="dd" 
                        maxlength="2"
                        pattern="[0-9]{2}"
                        class="<?php echo !empty($errors) ? 'input-error' : ''; ?>"
                        required>
                    <select 
                        id="mes" 
                        name="mes"
                        class="<?php echo !empty($errors) ? 'input-error' : ''; ?>"
                        required>
                        <option value=""><?php echo translate('month'); ?></option>
                        <option value="1"><?php echo translate('january'); ?></option>
                        <option value="2"><?php echo translate('february'); ?></option>
                        <option value="3"><?php echo translate('march'); ?></option>
                        <option value="4"><?php echo translate('april'); ?></option>
                        <option value="5"><?php echo translate('may'); ?></option>
                        <option value="6"><?php echo translate('june'); ?></option>
                        <option value="7"><?php echo translate('july'); ?></option>
                        <option value="8"><?php echo translate('august'); ?></option>
                        <option value="9"><?php echo translate('september'); ?></option>
                        <option value="10"><?php echo translate('october'); ?></option>
                        <option value="11"><?php echo translate('november'); ?></option>
                        <option value="12"><?php echo translate('december'); ?></option>
                    </select>
                    <input 
                        type="text" 
                        id="ano" 
                        name="ano" 
                        placeholder="aaaa" 
                        maxlength="4"
                        pattern="[0-9]{4}"
                        class="<?php echo !empty($errors) ? 'input-error' : ''; ?>"
                        required>
                </section>
            </section>

            <section class="form-grupo">
                <label for="genero"><?php echo translate('gender'); ?></label>
                <p class="descricao">
                    <?php echo translate('gender_help'); ?>
                </p>
                <section class="genero-opcoes">
                    <label class="opcao-radio">
                        <input type="radio" name="genero" value="mulher" required>
                        <span><?php echo translate('woman'); ?></span>
                    </label>
                    <label class="opcao-radio">
                        <input type="radio" name="genero" value="homem">
                        <span><?php echo translate('man'); ?></span>
                    </label>
                    <label class="opcao-radio">
                        <input type="radio" name="genero" value="nao-binario">
                        <span><?php echo translate('non_binary'); ?></span>
                    </label>
                    <label class="opcao-radio">
                        <input type="radio" name="genero" value="outro">
                        <span><?php echo translate('other'); ?></span>
                    </label>
                    <label class="opcao-radio">
                        <input type="radio" name="genero" value="prefiro-nao-dizer">
                        <span><?php echo translate('prefer_not_say'); ?></span>
                    </label>
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
        document.getElementById('returnSenha').addEventListener('click', function() {
            window.location.href = 'cadUsuarioSenha.php?lang=<?php echo $currentLang; ?>';
        });

        const submitBtn = document.getElementById('submitBtn');
        const nomeInput = document.getElementById('nome');
        const diaInput = document.getElementById('dia');
        const mesSelect = document.getElementById('mes');
        const anoInput = document.getElementById('ano');
        const generoRadios = document.querySelectorAll('input[name="genero"]');

        // Permitir apenas números nos campos de data
        diaInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);
            if (this.value.length === 2 && parseInt(this.value) > 0 && parseInt(this.value) <= 31) {
                mesSelect.focus();
            }
            validarFormulario();
        });

        anoInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
            validarFormulario();
        });

        nomeInput.addEventListener('input', validarFormulario);
        mesSelect.addEventListener('change', function() {
            if (this.value && anoInput.value.length < 4) {
                anoInput.focus();
            }
            validarFormulario();
        });
        
        generoRadios.forEach(radio => {
            radio.addEventListener('change', validarFormulario);
        });

        function validarFormulario() {
            const nome = nomeInput.value.trim();
            const dia = diaInput.value;
            const mes = mesSelect.value;
            const ano = anoInput.value;
            const generoSelecionado = document.querySelector('input[name="genero"]:checked');

            const diaValido = dia.length === 2 && parseInt(dia) >= 1 && parseInt(dia) <= 31;
            const mesValido = mes !== '';
            const anoValido = ano.length === 4 && parseInt(ano) >= 1900 && parseInt(ano) <= new Date().getFullYear();

            const isValid = nome !== '' && 
                           diaValido && 
                           mesValido && 
                           anoValido && 
                           generoSelecionado !== null;

            submitBtn.disabled = !isValid;
        }

        document.getElementById('formInfo').addEventListener('submit', function(e) {
            const dia = parseInt(diaInput.value);
            const mes = parseInt(mesSelect.value);
            const ano = parseInt(anoInput.value);

            // Validar data
            if (!validarData(dia, mes, ano)) {
                e.preventDefault();
                alert('Data de nascimento inválida');
                return;
            }

            // Validar idade mínima (13 anos)
            const hoje = new Date();
            const nascimento = new Date(ano, mes - 1, dia);
            const idade = Math.floor((hoje - nascimento) / (365.25 * 24 * 60 * 60 * 1000));
            
            if (idade < 13) {
                e.preventDefault();
                alert('Você precisa ter pelo menos 13 anos para se cadastrar');
                return;
            }
        });

        function validarData(dia, mes, ano) {
            if (mes < 1 || mes > 12) return false;
            
            const diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            
            // Verificar ano bissexto
            if ((ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0)) {
                diasPorMes[1] = 29;
            }
            
            return dia >= 1 && dia <= diasPorMes[mes - 1];
        }
    </script>
</body>
</html>