<?php
require_once 'config.php';
$pageTitle = translate('register_music');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $artista = trim($_POST['artista'] ?? '');
    $album = trim($_POST['album'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano = trim($_POST['ano'] ?? '');
    $duracao = trim($_POST['duracao'] ?? '');
    $letra = trim($_POST['letra'] ?? '');

    if (empty($titulo)) {
        $errors[] = 'Título da música é obrigatório';
    }
    
    if (empty($artista)) {
        $errors[] = 'Nome do artista é obrigatório';
    }
    
    if (empty($album)) {
        $errors[] = 'Nome do álbum é obrigatório';
    }
    
    if (empty($tipo)) {
        $errors[] = 'Tipo é obrigatório';
    }

    if (!empty($duracao) && !preg_match('/^\d{1,2}:\d{2}$/', $duracao)) {
        $errors[] = 'Formato de duração inválido. Use o formato MM:SS (ex: 3:45)';
    }
    
    if (!empty($ano) && (!is_numeric($ano) || $ano < 1900 || $ano > date('Y') + 1)) {
        $errors[] = 'Ano inválido';
    }
    
    if (!isset($_FILES['audio']) || $_FILES['audio']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Arquivo de áudio é obrigatório';
    } else {
        $allowed = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/flac'];
        $fileType = $_FILES['audio']['type'];
        
        if (!in_array($fileType, $allowed)) {
            $errors[] = 'Formato de áudio inválido. Use MP3, WAV ou FLAC';
        }
        
        $maxSize = 50 * 1024 * 1024; 
        if ($_FILES['audio']['size'] > $maxSize) {
            $errors[] = 'Arquivo de áudio muito grande. Máximo 50MB';
        }
    }

    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = $_FILES['capa']['type'];
        
        if (!in_array($fileType, $allowed)) {
            $errors[] = 'Formato de imagem inválido. Use JPG ou PNG';
        }
        
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($_FILES['capa']['size'] > $maxSize) {
            $errors[] = 'Arquivo de capa muito grande. Máximo 10MB';
        }
    }

    if (empty($errors)) {
        $musicData = [
            'titulo' => $titulo,
            'artista' => $artista,
            'album' => $album,
            'tipo' => $tipo,
            'genero' => $genero,
            'ano' => $ano,
            'duracao' => $duracao,
            'letra' => $letra,
            'dataCadastro' => date('Y-m-d H:i:s')
        ];

        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/musicas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $filename = uniqid('audio_') . '_' . basename($_FILES['audio']['name']);
            $uploadPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadPath)) {
                $musicData['audio'] = $filename;
                $musicData['audioTamanho'] = $_FILES['audio']['size'];
            }
        }

        if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/capas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $filename = uniqid('capa_') . '_' . basename($_FILES['capa']['name']);
            $uploadPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['capa']['tmp_name'], $uploadPath)) {
                $musicData['capa'] = $filename;
            }
        }

        $_SESSION['music_data'] = $musicData;
        
        $success = true;
    }
}

?>

<link rel="stylesheet" href="../css/style-formMusica.css">

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

        <h1 class="form-title"><?php echo translate('form_title_music'); ?></h1>
        <p class="form-subtitle"><?php echo translate('form_subtitle_music'); ?></p>

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
                <div class="alert-title">Música cadastrada com sucesso!</div>
                <div class="alert-description">
                    Título: <?php echo htmlspecialchars($musicData['titulo']); ?>
                </div>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo" class="form-label"><?php echo translate('music_title'); ?></label>
                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    placeholder="<?php echo translate('music_title_placeholder'); ?>"
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>"
                />
            </div>

            <div class="form-group">
                <label for="artista" class="form-label"><?php echo translate('artist'); ?></label>
                <input
                    type="text"
                    id="artista"
                    name="artista"
                    placeholder="<?php echo translate('artist_placeholder'); ?>"
                    required
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['artista'] ?? ''); ?>"
                />
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="album" class="form-label"><?php echo translate('album'); ?></label>
                    <input
                        type="text"
                        id="album"
                        name="album"
                        placeholder="<?php echo translate('album_placeholder'); ?>"
                        required
                        class="form-input"
                        value="<?php echo htmlspecialchars($_POST['album'] ?? ''); ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="tipo" class="form-label"><?php echo translate('type'); ?></label>
                    <input
                        list="opcoes-tipo"
                        id="tipo"
                        name="tipo"
                        required
                        class="form-input"
                        value="<?php echo htmlspecialchars($_POST['tipo'] ?? ''); ?>"
                    />
                    
                    <datalist id="opcoes-tipo">
                        <option value="Álbum">
                        <option value="EP">
                        <option value="Single">
                    </datalist>
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
                        value="<?php echo htmlspecialchars($_POST['genero'] ?? ''); ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="ano" class="form-label"><?php echo translate('year'); ?></label>
                    <input
                        type="number"
                        id="ano"
                        name="ano"
                        placeholder="2025"
                        class="form-input"
                        value="<?php echo htmlspecialchars($_POST['ano'] ?? ''); ?>"
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
                    class="form-input"
                    value="<?php echo htmlspecialchars($_POST['duracao'] ?? ''); ?>"
                />
            </div>

            <div class="form-group">
                <label for="letra" class="form-label"><?php echo translate('lyrics'); ?></label>
                <textarea
                    id="letra"
                    name="letra"
                    placeholder="<?php echo translate('lyrics_placeholder'); ?>"
                    rows="6"
                    class="form-textarea"
                ><?php echo htmlspecialchars($_POST['letra'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="audio" class="form-label"><?php echo translate('audio_file'); ?></label>
                <input
                    type="file"
                    id="audio"
                    name="audio"
                    accept="audio/*"
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
                    accept="image/*"
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