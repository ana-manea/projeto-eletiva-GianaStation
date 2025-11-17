<?php
require_once 'config.php';
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

$artist_id = $_SESSION['artist_id'];
$user_id = $_SESSION['user_id'];
$pageTitle = translateText('Perfil');

// Buscar dados do artista
$artista = buscarArtistaPorId($artist_id);
if (!$artista) {
    header('Location: pagInicial.php?lang=' . $currentLang);
    exit;
}

// Usar Capa_path como foto de perfil se Foto_perfil não existir
$foto_perfil = isset($artista['Foto_perfil']) && !empty($artista['Foto_perfil']) 
    ? $artista['Foto_perfil'] 
    : $artista['Capa_path'];

// Processar formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_artistico = limparDados($_POST['artistName']);
    $biografia = limparDados($_POST['bio']);
    $genero_art = limparDados($_POST['genres']);
    $instagram = limparDados($_POST['instagram']);
    $twitter = limparDados($_POST['twitter']);
    $tiktok = limparDados($_POST['tiktok']);
    $site = limparDados($_POST['website']);
    
    // Atualizar artista
    $resultado = atualizarArtista(
        $artist_id, 
        $nome_artistico, 
        $biografia, 
        $genero_art, 
        $instagram, 
        $twitter, 
        $tiktok, 
        $site
    );
    
    if ($resultado) {
        $_SESSION['profile_updated'] = true;
        header("Location: dashboardArtPerfil.php?lang=" . $currentLang . "&updated=1");
        exit;
    }
}

$showSuccess = isset($_GET['updated']) && $_GET['updated'] == '1';
?>

<link rel="stylesheet" href="../css/style-dashboardArtPerfil.css">

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo $pageTitle; ?> | Giana Station for Artists</title>
</head>
<body>
    <nav class="navbar">
        <section class="navbar-content">
            <section class="navbar-left">
                <a href="dashboardArtista.php" class="artist-profile">
                    <section class="artist-avatar">
                        <img src="<?php echo !empty($foto_perfil) ? htmlspecialchars($foto_perfil) : 'https://via.placeholder.com/100'; ?>" 
                             alt="<?php echo htmlspecialchars($artista['Nome_artistico']); ?>" id="navAvatar">
                    </section>
                    <section class="artist-info">
                        <h2 id="navName"><?php echo htmlspecialchars($artista['Nome_artistico']); ?></h2>
                        <p><?php echo translateText('Artista Verificado'); ?></p>
                    </section>
                </a>
                <section class="nav-links">
                    <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
                    <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Discografia'); ?></a>
                    <a href="dashboardArtAudiencia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Audiência'); ?></a>
                    <a href="dashboardArtPerfil.php?lang=<?php echo $currentLang; ?>" class="nav-link active"><?php echo translateText('Perfil'); ?></a>
                </section>
            </section>
            
            <section class="header-actions">
                <?php
                $buttonConfig = [
                    'position' => 'relative',
                    'showText' => false,
                    'style' => ''
                ];
                require_once 'languageBtn.php';
                ?>
                
                <button class="btn-outline" onclick="window.open('pagInicial.php?lang=<?php echo $currentLang; ?>', '_blank')">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    <span><?php echo translateText('Voltar ao Giana Station'); ?></span>
                </button>
                
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                    <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                    <svg class="close-icon" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </section>
        </section>

        <nav class="nav-mobile" id="navMobile">
            <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
            <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Discografia'); ?></a>
            <a href="dashboardArtAudiencia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Audiência'); ?></a>
            <a href="dashboardArtPerfil.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Perfil'); ?></a>
            
            <section class="mobile-actions">
                <?php
                $buttonConfig = [
                    'position' => 'relative',
                    'showText' => true,
                    'style' => ''
                ];
                require_once 'languageBtn.php';
                ?>
                
                <button class="btn-outline" onclick="window.open('pagInicial.php?lang=<?php echo $currentLang; ?>', '_blank')">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    <span><?php echo translateText('Voltar ao Giana Station'); ?></span>
                </button>
            </section>
        </nav>
    </nav>

    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <section class="profile-header">
        <section class="header-background" id="headerBackground" 
                 style="background-image: url('<?php echo !empty($artista['Capa_path']) ? htmlspecialchars($artista['Capa_path']) : 'https://via.placeholder.com/1920x400'; ?>')"></section>
        <section class="header-overlay"></section>
        
        <button class="upload-header-btn" id="uploadHeaderBtn" style="display: none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            <span><?php echo translateText('Atualizar Imagem de Capa'); ?></span>
        </button>

        <section class="profile-header-content">
            <section class="profile-avatar-wrapper">
                <img src="<?php echo !empty($foto_perfil) ? htmlspecialchars($foto_perfil) : 'https://via.placeholder.com/200'; ?>" 
                     alt="Profile" class="profile-avatar" id="profileAvatar">
                <button class="upload-avatar-btn" id="uploadAvatarBtn" style="display: none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </button>
            </section>
        </section>
    </section>

    <main class="main-content">
        <?php if ($showSuccess): ?>
            <section class="alert alert-success">
                <section class="alert-icon">✓</section>
                <section class="alert-title"><?php echo translateText('Perfil atualizado com sucesso!'); ?></section>
            </section>
        <?php endif; ?>

        <section class="page-header">
            <h1><?php echo translateText('Editar Perfil'); ?></h1>
            <section class="header-actions" id="headerActions">
                <button class="btn-primary" id="btnEdit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    <span><?php echo translateText('Editar Perfil'); ?></span>
                </button>
            </section>
            <section class="header-actions-editing" id="headerActionsEditing" style="display: none;">
                <button class="btn-secondary" id="btnCancel">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span><?php echo translateText('Cancelar'); ?></span>
                </button>
                <button class="btn-primary" id="btnSave">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    <span><?php echo translateText('Salvar Alterações'); ?></span>
                </button>
            </section>
        </section>

        <section class="card">
            <form id="profileForm" method="POST">
                <section class="form-section">
                    <h2><?php echo translateText('Informações Básicas'); ?></h2>
                    <section class="form-grid">
                        <section class="form-group full-width">
                            <label for="artistName"><?php echo translateText('Nome do Artista'); ?></label>
                            <input type="text" id="artistName" name="artistName" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Nome_artistico']); ?>" 
                                   maxlength="50" disabled>
                            <p class="char-count"><span id="artistNameCount">0</span>/50 <?php echo translate('characters'); ?></p>
                        </section>

                        <section class="form-group full-width">
                            <label for="bio"><?php echo translateText('Biografia'); ?></label>
                            <textarea name="bio" id="bio" class="form-textarea" rows="5" 
                                      maxlength="1000" disabled><?php echo htmlspecialchars($artista['Biografia'] ?? ''); ?></textarea>
                            <p class="char-count"><span id="bioCount">0</span>/1000 <?php echo translate('characters'); ?></p>
                        </section>

                        <section class="form-group">
                            <label for="genres"><?php echo translateText('Gêneros Musicais'); ?></label>
                            <input type="text" id="genres" name="genres" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Genero_art'] ?? ''); ?>" 
                                   placeholder="<?php echo translateText('Separados por vírgula'); ?>" disabled>
                        </section>
                    </section>
                </section>

                <section class="form-section">
                    <h2><?php echo translateText('Redes Sociais'); ?></h2>
                    <section class="form-grid2">
                        <section class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Site'] ?? ''); ?>" 
                                   placeholder="https://..." disabled>
                        </section>
                        <section class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" id="instagram" name="instagram" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Instagram'] ?? ''); ?>" 
                                   placeholder="@username" disabled>
                        </section>

                        <section class="form-group">
                            <label for="twitter">Twitter/X</label>
                            <input type="text" id="twitter" name="twitter" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Twitter'] ?? ''); ?>" 
                                   placeholder="@username" disabled>
                        </section>

                        <section class="form-group">
                            <label for="tiktok">TikTok</label>
                            <input type="text" id="tiktok" name="tiktok" class="form-input" 
                                   value="<?php echo htmlspecialchars($artista['Tiktok'] ?? ''); ?>" 
                                   placeholder="@username" disabled>
                        </section>
                    </section>
                </section>

                <section class="tips-card">
                    <h3><?php echo translateText('Dicas para um perfil incrível'); ?></h3>
                    <ul>
                        <li><?php echo translateText('• Use imagens de alta qualidade (Avatar: 750x750px, Capa: 2660x1140px)'); ?></li>
                        <li><?php echo translateText('• Mantenha sua biografia atualizada e interessante'); ?></li>
                        <li><?php echo translateText('• Inclua links para suas redes sociais'); ?></li>
                        <li><?php echo translateText('• Evite textos, logos e fundos muito ocupados nas imagens'); ?></li>
                    </ul>
                </section>
            </form>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'dashboardArtPerfil.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    require_once 'footerCadArtista.php';
    ?>

    <!-- Hidden file inputs -->
    <input type="file" id="headerImageInput" accept="image/*" style="display: none;">
    <input type="file" id="avatarImageInput" accept="image/*" style="display: none;">

    <script>
        function toggleLanguageModal() {
            const modal = document.getElementById('languageModal');
            if (modal) {
                const isHidden = modal.style.display === 'none' || !modal.style.display;
                modal.style.display = isHidden ? 'block' : 'none';
                document.body.style.overflow = isHidden ? 'hidden' : '';
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('languageModal');
            if (event.target === modal) {
                toggleLanguageModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('languageModal');
            if (e.key === 'Escape' && modal && modal.style.display === 'block') {
                toggleLanguageModal();
            }
        });

        function toggleMobileMenu() {
            const navMobile = document.getElementById('navMobile');
            const overlay = document.getElementById('mobileMenuOverlay');
            const body = document.body;
            const menuIcon = document.querySelector('.menu-icon');
            const closeIcon = document.querySelector('.close-icon');
            
            if (!navMobile || !overlay) return;
            
            const isActive = navMobile.classList.contains('active');
            
            navMobile.classList.toggle('active', !isActive);
            overlay.classList.toggle('active', !isActive);
            body.classList.toggle('menu-open', !isActive);
            
            if (menuIcon) menuIcon.style.display = isActive ? 'block' : 'none';
            if (closeIcon) closeIcon.style.display = isActive ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            }
            
            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', toggleMobileMenu);
            }
            
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        const navMobile = document.getElementById('navMobile');
                        const overlay = document.getElementById('mobileMenuOverlay');
                        const body = document.body;
                        
                        if (navMobile) navMobile.classList.remove('active');
                        if (overlay) overlay.classList.remove('active');
                        body.classList.remove('menu-open');
                    }
                }, 250);
            });
        });

        const CHARACTER_LIMITS = {
            bio: 1000,
            artistName: 50,
            genres: 100,
            website: 200,
            instagram: 50,
            twitter: 50,
            tiktok: 50
        };

        function updateCharacterCount(fieldId) {
            const field = document.getElementById(fieldId);
            const countElement = document.getElementById(`${fieldId}Count`);
            
            if (!field || !countElement) return;
            
            const currentLength = field.value.length;
            const maxLength = CHARACTER_LIMITS[fieldId] || 1000;
            
            countElement.textContent = currentLength;
            
            const percentage = (currentLength / maxLength) * 100;
            
            field.classList.remove('near-limit', 'at-limit');
            
            if (percentage >= 100) {
                countElement.style.color = '#ef4444';
                countElement.parentElement.style.color = '#ef4444';
                field.classList.add('at-limit');
            } else if (percentage >= 90) {
                countElement.style.color = '#f59e0b';
                countElement.parentElement.style.color = '#f59e0b';
                field.classList.add('near-limit');
            } else {
                countElement.style.color = 'rgba(255, 255, 255, 0.6)';
                countElement.parentElement.style.color = 'rgba(255, 255, 255, 0.6)';
            }
        }

        function enforceCharacterLimit(fieldId) {
            const field = document.getElementById(fieldId);
            if (!field) return;
            
            const maxLength = CHARACTER_LIMITS[fieldId];
            if (!maxLength) return;
            
            field.addEventListener('input', function() {
                if (this.value.length > maxLength) {
                    this.value = this.value.substring(0, maxLength);
                }
                updateCharacterCount(fieldId);
            });
        }

        function initCharacterCounters() {
            const fieldsWithCounter = ['bio', 'artistName', 'genres', 'website', 'instagram', 'twitter', 'tiktok'];
            
            fieldsWithCounter.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    updateCharacterCount(fieldId);
                    enforceCharacterLimit(fieldId);
                }
            });
        }

        // Editar perfil
        function setupProfileEditing() {
            const btnEdit = document.getElementById('btnEdit');
            const btnCancel = document.getElementById('btnCancel');
            const btnSave = document.getElementById('btnSave');
            const headerActions = document.getElementById('headerActions');
            const headerActionsEditing = document.getElementById('headerActionsEditing');
            const uploadHeaderBtn = document.getElementById('uploadHeaderBtn');
            const uploadAvatarBtn = document.getElementById('uploadAvatarBtn');
            
            const editableFields = [
                'artistName', 'bio', 'genres', 
                'website', 'instagram', 'twitter', 'tiktok'
            ];
            
            let originalValues = {};
           
            function enableEditMode() {
                editableFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        originalValues[fieldId] = field.value;
                        field.disabled = false;
                        field.style.cursor = 'text';
                    }
                });
                
                if (headerActions) headerActions.style.display = 'none';
                if (headerActionsEditing) headerActionsEditing.style.display = 'flex';
                if (uploadHeaderBtn) uploadHeaderBtn.style.display = 'flex';
                if (uploadAvatarBtn) uploadAvatarBtn.style.display = 'flex';
            }
            
            function disableEditMode() {
                editableFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.disabled = true;
                        field.style.cursor = 'default';
                        field.classList.remove('near-limit', 'at-limit');
                    }
                });
                
                if (headerActions) headerActions.style.display = 'flex';
                if (headerActionsEditing) headerActionsEditing.style.display = 'none';
                if (uploadHeaderBtn) uploadHeaderBtn.style.display = 'none';
                if (uploadAvatarBtn) uploadAvatarBtn.style.display = 'none';
            }
            
            function restoreOriginalValues() {
                editableFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field && originalValues[fieldId] !== undefined) {
                        field.value = originalValues[fieldId];
                        updateCharacterCount(fieldId);
                    }
                });
            }
            
            if (btnEdit) {
                btnEdit.addEventListener('click', enableEditMode);
            }
            
            if (btnCancel) {
                btnCancel.addEventListener('click', () => {
                    restoreOriginalValues();
                    disableEditMode();
                });
            }
            
            if (btnSave) {
                btnSave.addEventListener('click', () => {
                    document.getElementById('profileForm').submit();
                });
            }
            
            setupImageUpload();
        }

        function setupImageUpload() {
            const uploadHeaderBtn = document.getElementById('uploadHeaderBtn');
            const uploadAvatarBtn = document.getElementById('uploadAvatarBtn');
            const headerImageInput = document.getElementById('headerImageInput');
            const avatarImageInput = document.getElementById('avatarImageInput');
            const headerBackground = document.getElementById('headerBackground');
            const profileAvatar = document.getElementById('profileAvatar');
            const navAvatar = document.getElementById('navAvatar');
            
            if (uploadHeaderBtn && headerImageInput) {
                uploadHeaderBtn.addEventListener('click', () => {
                    headerImageInput.click();
                });
                
                headerImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (headerBackground) {
                                headerBackground.style.backgroundImage = `url(${e.target.result})`;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            if (uploadAvatarBtn && avatarImageInput) {
                uploadAvatarBtn.addEventListener('click', () => {
                    avatarImageInput.click();
                });
                
                avatarImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (profileAvatar) {
                                profileAvatar.src = e.target.result;
                            }
                            if (navAvatar) {
                                navAvatar.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initCharacterCounters();
            setupProfileEditing();
        });
    </script>
</body>
</html>