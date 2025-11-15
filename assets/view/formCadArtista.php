<?php
require_once 'config.php';
$pageTitle = translate('register_artist');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');
    $twitter = trim($_POST['twitter'] ?? '');
    $tiktok = trim($_POST['tiktok'] ?? '');
    $website = trim($_POST['website'] ?? '');
    
    if (empty($nome)) {
        $errors[] = 'Nome artístico é obrigatório';
    } elseif (mb_strlen($nome) > 50) {
        $errors[] = 'Nome artístico deve ter no máximo 50 caracteres';
    }
    
    if (empty($instagram)) {
        $errors[] = 'Instagram é obrigatório';
    } elseif (!filter_var($instagram, FILTER_VALIDATE_URL)) {
        $errors[] = 'URL do Instagram inválida';
    }
    
    if (!empty($bio) && mb_strlen($bio) > 1000) {
        $errors[] = 'Biografia deve ter no máximo 1000 caracteres';
    }
    
    if (!empty($twitter) && !filter_var($twitter, FILTER_VALIDATE_URL)) {
        $errors[] = 'URL do Twitter inválida';
    }
    
    if (!empty($tiktok) && !filter_var($tiktok, FILTER_VALIDATE_URL)) {
        $errors[] = 'URL do TikTok inválida';
    }
    
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = 'URL do Website inválida';
    }
    
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = $_FILES['capa']['type'];
        
        if (!in_array($fileType, $allowed)) {
            $errors[] = 'Formato de imagem inválido. Use JPG ou PNG';
        }
        
        $maxSize = 10 * 1024 * 1024; 
        if ($_FILES['capa']['size'] > $maxSize) {
            $errors[] = 'Arquivo de capa muito grande. Máximo 10MB';
        }
    }
    
    if (empty($errors)) {
        
        $artistData = [
            'nome' => $nome,
            'genero' => $genero,
            'bio' => $bio,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'tiktok' => $tiktok,
            'website' => $website,
            'dataCadastro' => date('Y-m-d H:i:s')
        ];
        
        if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/capas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $filename = uniqid('capa_') . '_' . basename($_FILES['capa']['name']);
            $uploadPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['capa']['tmp_name'], $uploadPath)) {
                $artistData['capa'] = $filename;
            }
        }
        
        $_SESSION['artist_data'] = $artistData;
        
        $success = true;
    }
}
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

        <?php if ($success): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <div class="alert-title">Perfil de artista criado com sucesso!</div>
                <div class="alert-description">
                    Nome: <?php echo htmlspecialchars($artistData['nome']); ?>
                </div>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" enctype="multipart/form-data">
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
                    value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"
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
                    accept="image/*"
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
                    value="<?php echo htmlspecialchars($_POST['genero'] ?? ''); ?>"
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
                ><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
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
                    value="<?php echo htmlspecialchars($_POST['instagram'] ?? ''); ?>"
                />

                <label for="twitter" class="form-label">Twitter / X</label>
                <input
                    type="url"
                    id="twitter"
                    name="twitter"
                    placeholder="https://x.com/..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['twitter'] ?? ''); ?>"
                />

                <label for="tiktok" class="form-label">TikTok</label>
                <input
                    type="url"
                    id="tiktok"
                    name="tiktok"
                    placeholder="https://www.tiktok.com/..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['tiktok'] ?? ''); ?>"
                />

                <label for="website" class="form-label">Website</label>
                <input
                    type="url"
                    id="website"
                    name="website"
                    placeholder="https://..."
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['website'] ?? ''); ?>"
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