<?php
require_once 'config.php';
$pageTitle = translateText('Perfil');

// Dados do artista (exemplo - substituir por dados do banco)
$artistData = [
    'nome' => 'AnaVitória',
    'bio' => 'ANAVITÓRIA é uma dupla musical brasileira formada por Ana Caetano e Vitória Falcão. Naturais de Araguaína, Tocantins, iniciaram a carreira em 2015 e rapidamente conquistaram o público brasileiro com letras sobre amor e autodescoberta.',
    'localizacao' => 'São Paulo, Brasil',
    'generos' => 'MPB, Pop, Folk-pop',
    'website' => 'https://www.asanavitoria.com',
    'instagram' => '@anavitoria',
    'twitter' => '@oanavitoria',
    'tiktok' => '@asanavitoria',
    'avatar' => 'https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4',
    'capa' => 'https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4'
];

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui você processaria a atualização dos dados
    // Por enquanto, apenas simula o sucesso
    $_SESSION['profile_updated'] = true;
    header("Location: dashboardArtPerfil.php?lang=" . $currentLang . "&updated=1");
    exit;
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
                <a href="pagInicial.php" class="artist-profile">
                    <section class="artist-avatar">
                        <img src="<?php echo htmlspecialchars($artistData['avatar']); ?>" alt="<?php echo htmlspecialchars($artistData['nome']); ?>" id="navAvatar">
                    </section>
                    <section class="artist-info">
                        <h2 id="navName"><?php echo htmlspecialchars($artistData['nome']); ?></h2>
                        <p><?php echo translateText('Artista Verificado'); ?></p>
                    </section>
                </a>
                <section class="nav-links">
                    <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
                    <a href="dashboardArtMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Música'); ?></a>
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
            <a href="dashboardArtMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Música'); ?></a>
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
        <section class="header-background" id="headerBackground" style="background-image: url('<?php echo htmlspecialchars($artistData['capa']); ?>')"></section>
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
                <img src="<?php echo htmlspecialchars($artistData['avatar']); ?>" alt="Profile" class="profile-avatar" id="profileAvatar">
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
                                   value="<?php echo htmlspecialchars($artistData['nome']); ?>" 
                                   maxlength="50" disabled>
                            <p class="char-count"><span id="artistNameCount">0</span>/50 <?php echo translate('characters'); ?></p>
                        </section>

                        <section class="form-group full-width">
                            <label for="bio"><?php echo translateText('Biografia'); ?></label>
                            <textarea name="bio" id="bio" class="form-textarea" rows="5" 
                                      maxlength="1000" disabled><?php echo htmlspecialchars($artistData['bio']); ?></textarea>
                            <p class="char-count"><span id="bioCount">0</span>/1000 <?php echo translate('characters'); ?></p>
                        </section>

                        <section class="form-group">
                            <label for="location"><?php echo translateText('Localização'); ?></label>
                            <input type="text" id="location" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['localizacao']); ?>" disabled>
                        </section>

                        <section class="form-group">
                            <label for="genres"><?php echo translateText('Gêneros Musicais'); ?></label>
                            <input type="text" id="genres" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['generos']); ?>" 
                                   placeholder="<?php echo translateText('Separados por vírgula'); ?>" disabled>
                        </section>
                    </section>
                </section>

                <section class="form-section">
                    <h2><?php echo translateText('Redes Sociais'); ?></h2>
                    <section class="form-grid2">
                        <section class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['website']); ?>" 
                                   placeholder="https://..." disabled>
                        </section>
                        <section class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" id="instagram" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['instagram']); ?>" 
                                   placeholder="@username" disabled>
                        </section>

                        <section class="form-group">
                            <label for="twitter">Twitter/X</label>
                            <input type="text" id="twitter" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['twitter']); ?>" 
                                   placeholder="@username" disabled>
                        </section>

                        <section class="form-group">
                            <label for="tiktok">TikTok</label>
                            <input type="text" id="tiktok" class="form-input" 
                                   value="<?php echo htmlspecialchars($artistData['tiktok']); ?>" 
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
    ?>

    <footer>
        <section class="footer-container">
            <section class="footer-logo">
                <a href="pagInicial.php" class="logo">
                    <img src="../img/GA-Station.png" alt="Giana Station" style="width: 32px; height: 32px;">
                    <span>Giana Station</span>
                </a>
            </section>

            <section class="footer-grid">
                <section class="footer-col">
                    <h3><?php echo translate('useful_links'); ?></h3>
                    <ul>
                        <li><a href="#"><?php echo translate('about'); ?></a></li>
                        <li><a href="#"><?php echo translate('press_media'); ?></a></li>
                        <li><a href="#"><?php echo translate('services'); ?></a></li>
                        <li><a href="#">Loud & Clear</a></li>
                        <li><a href="#"><?php echo translate('contact'); ?></a></li>
                    </ul>
                </section>

                <section class="footer-col">
                    <h3><?php echo translate('creator_tools'); ?></h3>
                    <ul>
                        <li><a href="#">Giana Station for Authors</a></li>
                        <li><a href="#">Giana Station for Podcasters</a></li>
                        <li><a href="#">Songwriting</a></li>
                    </ul>
                </section>

                <section class="footer-col">
                    <h3><?php echo translate('download_app'); ?></h3>
                    <a href="#" class="app-download">
                        <img src="https://images.ctfassets.net/lnhrh9gqejzl/3f47r3hsq1UeTC7YDVVdpX/0cd2ca1606246e4bd1d854cefab06972/footer-ios-a77e2676a3ffba2c521ce743a6d82eea.svg" alt="Download na App Store">
                    </a>
                    
                    <a href="#" class="app-download">
                        <img src="https://images.ctfassets.net/lnhrh9gqejzl/3v0BeAMmo25nBpqqYKTiAf/fc5fe970d1f54f73270110dd54512fd7/footer-android-1e8a7815136447656dae5d9e77dfd5ad.svg" alt="Download no Google Play">
                    </a>
                </section>

                <section class="footer-col footer-social" style="flex-direction: row;">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="social-icon-round">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    
                    <a href="https://twitter.com/" target="_blank" rel="noopener noreferrer" class="social-icon-round">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    
                    <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="social-icon-round">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                </section>
            </section>

            <section class="footer-bottom">
                <section class="footer-links-bottom">
                    <span>© 2025 Giana Station</span>
                    <a href="#"><?php echo translate('legal'); ?></a>
                    <a href="#"><?php echo translate('privacy'); ?></a>
                    <a href="#"><?php echo translate('cookies'); ?></a>
                </section>

                <section>
                    <button class="btn-language" onclick="toggleLanguageModal()">
                        <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                        </svg>
                        <span><?php echo $availableLanguages[$currentLang]['name']; ?></span>
                    </button>
                </section>
            </section>
        </section>
    </footer>

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
            location: 100,
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
            const fieldsWithCounter = ['bio', 'artistName', 'location', 'genres', 'website', 'instagram', 'twitter', 'tiktok'];
            
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
                'artistName', 'bio', 'location', 'genres', 
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