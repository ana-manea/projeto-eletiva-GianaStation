<?php
require_once 'config.php';
$pageTitle = translate('register_artist');

// Verificar se usuário está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Você precisa estar logado para cadastrar um artista';
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

// Recuperar erros e dados do formulário da sessão
$errors = $_SESSION['artista_errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];

// Limpar mensagens após exibir
unset($_SESSION['artista_errors']);
?>

<link rel="stylesheet" href="../css/style-formArtista.css">

<?php require_once 'headerCadArtista.php'; ?>

<section class="container">
    <div class="form-wrapper">
        <a href="cadastrarArtistaMusica.php?lang=<?php echo $currentLang; ?>" class="back-link">
            <svg class="icon-small" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            <span><?php echo translate('back'); ?></span>
        </a>

        <h1 class="form-title"><?php echo translate('form_title_artist'); ?></h1>
        <p class="form-subtitle"><?php echo translate('form_subtitle_artist'); ?></p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p class="alert-message">⚠ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" action="../processamento/processamentoCadArtista.php" enctype="multipart/form-data">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <div class="form-group">
                <label for="nome" class="form-label"><?php echo translate('artist_name'); ?> *</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="<?php echo translate('artist_name_placeholder'); ?>"
                    maxlength="50"
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['nome'] ?? ''); ?>"
                    oninput="updateCounter('nome', 50)"
                />
                <p class="char-count"><span id="nomeCount">0</span>/50 <?php echo translate('characters'); ?></p>
            </div>

            <div class="form-group">
                <label for="capa" class="form-label"><?php echo translate('profile_cover'); ?></label>
                <input
                    type="file"
                    id="capa"
                    name="capa"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    class="form-file"
                />
                <p class="form-help"><?php echo translate('profile_cover_help'); ?></p>
            </div>

            <div class="form-group">
                <label for="genero" class="form-label"><?php echo translate('music_genre'); ?></label>
                <input
                    type="text"
                    id="genero"
                    name="genero"
                    placeholder="<?php echo translate('genre_placeholder'); ?>"
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['genero'] ?? ''); ?>"
                />
            </div>

            <div class="form-group">
                <label for="bio" class="form-label"><?php echo translate('biography'); ?></label>
                <textarea
                    id="bio"
                    name="bio"
                    placeholder="<?php echo translate('bio_placeholder'); ?>"
                    rows="4"
                    maxlength="1000"
                    class="form-textarea"
                    oninput="updateCounter('bio', 1000)"
                ><?php echo htmlspecialchars($formData['bio'] ?? ''); ?></textarea>
                <p class="char-count"><span id="bioCount">0</span>/1000 <?php echo translate('characters'); ?></p>
            </div>

            <div class="form-group">
                <label for="instagram" class="form-label">Instagram *</label>
                <input
                    type="url"
                    id="instagram"
                    name="instagram"
                    placeholder="https://www.instagram.com/..."
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['instagram'] ?? ''); ?>"
                />

                <label for="twitter" class="form-label" style="margin-top: 1rem;">Twitter / X</label>
                <input
                    type="url"
                    id="twitter"
                    name="twitter"
                    placeholder="https://x.com/..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['twitter'] ?? ''); ?>"
                />

                <label for="tiktok" class="form-label" style="margin-top: 1rem;">TikTok</label>
                <input
                    type="url"
                    id="tiktok"
                    name="tiktok"
                    placeholder="https://www.tiktok.com/..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['tiktok'] ?? ''); ?>"
                />

                <label for="website" class="form-label" style="margin-top: 1rem;">Website</label>
                <input
                    type="url"
                    id="website"
                    name="website"
                    placeholder="https://..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['website'] ?? ''); ?>"
                />
            </div>

            <button type="submit" class="btn-submit">
                <?php echo translate('create_profile'); ?>
            </button>
        </form>
    </div>
</section>

<script>
function updateCounter(fieldId, maxLength) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(fieldId + 'Count');
    const currentLength = field.value.length;
    counter.textContent = currentLength;
    
    const percentage = (currentLength / maxLength) * 100;
    
    if (percentage >= 100) {
        counter.style.color = '#ef4444';
        field.classList.add('at-limit');
    } else if (percentage >= 90) {
        counter.style.color = '#f59e0b';
        field.classList.add('near-limit');
        field.classList.remove('at-limit');
    } else {
        counter.style.color = 'rgba(255, 255, 255, 0.6)';
        field.classList.remove('near-limit', 'at-limit');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateCounter('nome', 50);
    updateCounter('bio', 1000);
});
</script>

<?php require_once 'footerCadArtista.php'; ?>