<?php
require_once 'config.php';
$pageTitle = translate('register_music');

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    $_SESSION['error_message'] = 'Você precisa ter um perfil de artista para cadastrar músicas';
    header('Location: cadastrarArtistaMusica.php?lang=' . $currentLang);
    exit;
}

// Recuperar erros e dados do formulário da sessão
$errors = $_SESSION['musica_errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];

// Limpar mensagens após exibir
unset($_SESSION['musica_errors']);
?>

<link rel="stylesheet" href="../css/style-formMusica.css">

<?php require_once 'headerCadArtista.php'; ?>

<section class="container">
    <div class="form-wrapper">
        <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="back-link">
            <svg class="icon-small" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            <span><?php echo translate('back'); ?></span>
        </a>

        <h1 class="form-title"><?php echo translate('form_title_music'); ?></h1>
        <p class="form-subtitle"><?php echo translate('form_subtitle_music'); ?></p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p class="alert-message">⚠ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" action="../processamento/processamentoCadMusica.php" enctype="multipart/form-data">
            <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
            
            <div class="form-group">
                <label for="titulo" class="form-label"><?php echo translate('music_title'); ?> *</label>
                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    placeholder="<?php echo translate('music_title_placeholder'); ?>"
                    maxlength="200"
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['titulo'] ?? ''); ?>"
                />
            </div>

            <div class="form-group">
                <label for="artista" class="form-label"><?php echo translate('artist'); ?> *</label>
                <input
                    type="text"
                    id="artista"
                    name="artista"
                    placeholder="<?php echo translate('artist_placeholder'); ?>"
                    maxlength="200"
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['artista'] ?? ''); ?>"
                />
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="album" class="form-label"><?php echo translate('album'); ?> *</label>
                    <input
                        type="text"
                        id="album"
                        name="album"
                        placeholder="<?php echo translate('album_placeholder'); ?>"
                        maxlength="200"
                        required
                        class="form-input"
                        value="<?php echo htmlspecialchars($formData['album'] ?? ''); ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="tipo" class="form-label"><?php echo translate('type'); ?> *</label>
                    <select id="tipo" name="tipo" required class="form-input">
                        <option value="">Selecione...</option>
                        <option value="Álbum" <?php echo (isset($formData['tipo']) && $formData['tipo'] === 'Álbum') ? 'selected' : ''; ?>>Álbum</option>
                        <option value="EP" <?php echo (isset($formData['tipo']) && $formData['tipo'] === 'EP') ? 'selected' : ''; ?>>EP</option>
                        <option value="Single" <?php echo (isset($formData['tipo']) && $formData['tipo'] === 'Single') ? 'selected' : ''; ?>>Single</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
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
                    <label for="ano" class="form-label"><?php echo translate('year'); ?></label>
                    <input
                        type="number"
                        id="ano"
                        name="ano"
                        placeholder="2025"
                        min="1900"
                        max="<?php echo date('Y') + 1; ?>"
                        class="form-input"
                        value="<?php echo htmlspecialchars($formData['ano'] ?? date('Y')); ?>"
                    />
                </div>
            </div>

            <div class="form-group">
                <label for="duracao" class="form-label"><?php echo translate('duration'); ?></label>
                <input
                    type="text"
                    id="duracao"
                    name="duracao"
                    placeholder="Ex: 3:45"
                    pattern="\d{1,2}:\d{2}"
                    title="Use o formato MM:SS (exemplo: 3:45)"
                    class="form-input"
                    value="<?php echo htmlspecialchars($formData['duracao'] ?? ''); ?>"
                />
                <p class="form-help">Formato: MM:SS (exemplo: 3:45)</p>
            </div>

            <div class="form-group">
                <label for="letra" class="form-label"><?php echo translate('lyrics'); ?></label>
                <textarea
                    id="letra"
                    name="letra"
                    placeholder="<?php echo translate('lyrics_placeholder'); ?>"
                    rows="6"
                    maxlength="500"
                    class="form-textarea"
                ><?php echo htmlspecialchars($formData['letra'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="audio" class="form-label"><?php echo translate('audio_file'); ?> *</label>
                <input
                    type="file"
                    id="audio"
                    name="audio"
                    accept="audio/mpeg,audio/mp3,audio/wav,audio/flac,audio/m4a"
                    required
                    class="form-file"
                />
                <p class="form-help"><?php echo translate('audio_help'); ?></p>
            </div>

            <div class="form-group">
                <label for="capa" class="form-label"><?php echo translate('cover_single'); ?></label>
                <input
                    type="file"
                    id="capa"
                    name="capa"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    class="form-file"
                />
                <p class="form-help"><?php echo translate('cover_help'); ?></p>
            </div>

            <button type="submit" class="btn-submit">
                <?php echo translate('submit_music'); ?>
            </button>
        </form>
    </div>
</section>

<?php require_once 'footerCadArtista.php'; ?>