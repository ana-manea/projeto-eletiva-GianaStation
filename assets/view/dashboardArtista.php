<?php
require_once 'config.php';
$pageTitle = 'Dashboard';
?>

<link rel="stylesheet" href="../css/style-dashboardArtista.css">

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo $pageTitle; ?> | Giana Station for Artists</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <section class="navbar-content">
            <section class="navbar-left">
                <a href="pagInicial.php" class="artist-profile">
                    <section class="artist-avatar">
                        <img src="https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4" alt="AnaVitoria">
                    </section>
                    <section class="artist-info">
                        <h2><?php echo translate('artist_name'); ?></h2>
                        <p><?php echo translateText('Artista Verificado'); ?></p>
                    </section>
                </a>
                <section class="nav-links">
                    <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link active"><?php echo translate('home'); ?></a>
                    <a href="dashboardArtMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Música'); ?></a>
                    <a href="dashboardArtAudiencia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Audiência'); ?></a>
                    <a href="dashboardArtPerfil.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Perfil'); ?></a>
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

    <section class="hero-section">
        <section class="hero-background" style="background-image: url('https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4')"></section>
        <section class="hero-overlay"></section>
        <section class="hero-content">
            <section class="hero-profile">
                <section class="hero-avatar">
                    <img src="https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4" alt="AnaVitoria">
                </section>
                <section class="hero-info">
                    <span class="badge-verified"><?php echo translateText('ARTISTA VERIFICADO'); ?></span>
                    <h1><?php echo translateText('AnaVitória'); ?></h1>
                    <p><?php echo translateText('21.201 ouvintes mensais'); ?></p>
                </section>
            </section>
        </section>
    </section>

    <main class="main-content">
        <section class="stats-grid">
            <section class="stat-card stat-primary">
                <section class="stat-header">
                    <p><?php echo translateText('Streams Totais'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </section>
                <p class="stat-value">24.5K</p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo translateText('+12.5% este mês'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-blue">
                <section class="stat-header">
                    <p><?php echo translateText('Ouvintes Mensais'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </section>
                <p class="stat-value">21.2K</p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo translateText('+8.3% este mês'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-purple">
                <section class="stat-header">
                    <p><?php echo translateText('Lançamentos'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </section>
                <p class="stat-value">12</p>
                <p class="stat-change neutral">
                    <span><?php echo translateText('4 singles, 5 EPs, 3 álbuns'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-accent">
                <section class="stat-header">
                    <p><?php echo translateText('Seguidores'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </section>
                <p class="stat-value">5.3K</p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo translateText('+170 esta semana'); ?></span>
                </p>
            </section>
        </section>

        <section class="content-grid">
            <section class="content-left">
                <section class="section">
                    <section class="section-header">
                        <h2><?php echo translateText('Lançamentos Recentes'); ?></h2>
                        <a href="dashboardArtMusica.php?lang=<?php echo $currentLang; ?>" class="link-primary"><?php echo translateText('Ver todos'); ?></a>
                    </section>
                    <section class="releases-grid" id="recentReleases"></section>
                </section>

                <section class="section">
                    <section class="card">
                        <h2><?php echo translateText('Visão Geral de Performance'); ?></h2>
                        <section class="performance-list">
                            <section class="performance-item">
                                <div>
                                    <p class="performance-label"><?php echo translateText('Últimos 7 dias'); ?></p>
                                    <p class="performance-value">7,964</p>
                                    <p class="performance-unit"><?php echo translateText('streams'); ?></p>
                                </div>
                                <section class="performance-change positive">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                        <polyline points="17 6 23 6 23 12"/>
                                    </svg>
                                    <span>+15.3%</span>
                                </section>
                            </section>
                            <section class="performance-item">
                                <div>
                                    <p class="performance-label"><?php echo translateText('Últimos 28 dias'); ?></p>
                                    <p class="performance-value">24,531</p>
                                    <p class="performance-unit"><?php echo translateText('streams'); ?></p>
                                </div>
                                <section class="performance-change positive">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                        <polyline points="17 6 23 6 23 12"/>
                                    </svg>
                                    <span>+8.7%</span>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>

            <section class="content-right">
                <section class="section">
                    <section class="card">
                        <section class="section-header">
                            <h2><?php echo translateText('Top Músicas'); ?></h2>
                            <a href="dashboardArtAudiencia.php?lang=<?php echo $currentLang; ?>" class="link-primary"><?php echo translateText('Ver detalhes'); ?></a>
                        </section>
                        <section class="top-songs-list" id="topSongsList"></section>
                    </section>
                </section>

                <section class="section">
                    <section class="card card-gradient">
                        <h2><?php echo translateText('Informações do Artista'); ?></h2>
                        <section class="artist-info-list">
                            <section class="info-item">
                                <p class="info-label"><?php echo translateText('Gêneros'); ?></p>
                                <p class="info-value"><?php echo translateText('MPB, Pop, Folk-pop'); ?></p>
                            </section>
                            <section class="info-item">
                                <p class="info-label"><?php echo translateText('Status'); ?></p>
                                <span class="badge-active"><?php echo translateText('Ativo'); ?></span>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'dashboardArtista.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    require_once 'footerCadArtista.php';
    ?>

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
    </script>
</body>
</html>