<?php
require_once 'config.php';
$pageTitle = translateText('Discografia');

// Dados de exemplo - substituir por dados do banco
$discografia = [
    'albums' => [
        [
            'id' => 1,
            'titulo' => 'Trevo',
            'ano' => 2017,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
            'tipo' => 'Álbum',
            'faixas' => 14,
            'streams' => '2.5M'
        ],
        [
            'id' => 2,
            'titulo' => 'O Tempo É Agora',
            'ano' => 2018,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2735d7cf1a8508aa994d4bde5c8',
            'tipo' => 'Álbum',
            'faixas' => 12,
            'streams' => '3.1M'
        ],
        [
            'id' => 3,
            'titulo' => 'Esquinas',
            'ano' => 2024,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
            'tipo' => 'Álbum',
            'faixas' => 12,
            'streams' => '1.8M'
        ]
    ],
    'eps' => [
        [
            'id' => 4,
            'titulo' => 'Ao Vivo em São Paulo',
            'ano' => 2019,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
            'tipo' => 'EP',
            'faixas' => 6,
            'streams' => '890K'
        ]
    ],
    'singles' => [
        [
            'id' => 5,
            'titulo' => 'Trevo (Tu)',
            'ano' => 2017,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
            'tipo' => 'Single',
            'faixas' => 1,
            'streams' => '450K'
        ]
    ]
];
?>

<link rel="stylesheet" href="../css/style-dashboardArtDiscografia.css">

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
                        <img src="https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4" alt="AnaVitória">
                    </section>
                    <section class="artist-info">
                        <h2><?php echo translateText('AnaVitória'); ?></h2>
                        <p><?php echo translateText('Artista Verificado'); ?></p>
                    </section>
                </a>
                <section class="nav-links">
                    <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
                    <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="nav-link active"><?php echo translateText('Discografia'); ?></a>
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
  
    <main class="main-content">
        <section class="page-header">
            <div>
                <h1><?php echo translateText('Discografia'); ?></h1>
                <p><?php echo translateText('Gerencie seus álbuns, EPs e singles'); ?></p>
            </div>
            <button class="btn-primary" id="btnAddRelease">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                <span><?php echo translateText('Adicionar Lançamento'); ?></span>
            </button>
        </section>

        <section class="stats-overview">
            <section class="stat-card">
                <div class="stat-icon-wrapper stat-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-value"><?php echo count($discografia['albums']); ?></p>
                    <p class="stat-label"><?php echo translateText('Álbuns'); ?></p>
                </div>
            </section>

            <section class="stat-card">
                <div class="stat-icon-wrapper stat-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-value"><?php echo count($discografia['eps']); ?></p>
                    <p class="stat-label"><?php echo translateText('EPs'); ?></p>
                </div>
            </section>

            <section class="stat-card">
                <div class="stat-icon-wrapper stat-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-value"><?php echo count($discografia['singles']); ?></p>
                    <p class="stat-label"><?php echo translateText('Singles'); ?></p>
                </div>
            </section>
        </section>

        <!-- Filtros -->
        <section class="filter-tabs">
            <button class="filter-tab active" data-filter="all"><?php echo translateText('Todos'); ?></button>
            <button class="filter-tab" data-filter="albums"><?php echo translateText('Álbuns'); ?></button>
            <button class="filter-tab" data-filter="eps"><?php echo translateText('EPs'); ?></button>
            <button class="filter-tab" data-filter="singles"><?php echo translateText('Singles'); ?></button>
        </section>

        <!-- Álbuns -->
        <section class="release-section" data-type="albums">
            <h2 class="section-title"><?php echo translateText('Álbuns'); ?></h2>
            <section class="releases-grid">
                <?php foreach ($discografia['albums'] as $album): ?>
                    <article class="release-card" data-id="<?php echo $album['id']; ?>">
                        <div class="release-actions">
                            <button class="btn-icon" onclick="editRelease(<?php echo $album['id']; ?>, 'album')" title="Editar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="btn-icon btn-danger" onclick="deleteRelease(<?php echo $album['id']; ?>, 'album')" title="Excluir">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                        <div class="release-cover" onclick="viewRelease(<?php echo $album['id']; ?>, 'album')">
                            <img src="<?php echo $album['capa']; ?>" alt="<?php echo htmlspecialchars($album['titulo']); ?>">
                        </div>
                        <div class="release-info">
                            <span class="release-badge"><?php echo $album['tipo']; ?></span>
                            <h3><?php echo htmlspecialchars($album['titulo']); ?></h3>
                            <p class="release-year"><?php echo $album['ano']; ?></p>
                            <div class="release-meta">
                                <span><?php echo $album['faixas']; ?> <?php echo translateText('faixas'); ?></span>
                                <span>•</span>
                                <span><?php echo $album['streams']; ?> streams</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </section>

        <!-- EPs -->
        <section class="release-section" data-type="eps">
            <h2 class="section-title"><?php echo translateText('EPs'); ?></h2>
            <section class="releases-grid">
                <?php foreach ($discografia['eps'] as $ep): ?>
                    <article class="release-card" data-id="<?php echo $ep['id']; ?>">
                        <div class="release-actions">
                            <button class="btn-icon" onclick="editRelease(<?php echo $ep['id']; ?>, 'ep')" title="Editar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="btn-icon btn-danger" onclick="deleteRelease(<?php echo $ep['id']; ?>, 'ep')" title="Excluir">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                        <div class="release-cover" onclick="viewRelease(<?php echo $ep['id']; ?>, 'ep')">
                            <img src="<?php echo $ep['capa']; ?>" alt="<?php echo htmlspecialchars($ep['titulo']); ?>">
                        </div>
                        <div class="release-info">
                            <span class="release-badge badge-blue"><?php echo $ep['tipo']; ?></span>
                            <h3><?php echo htmlspecialchars($ep['titulo']); ?></h3>
                            <p class="release-year"><?php echo $ep['ano']; ?></p>
                            <div class="release-meta">
                                <span><?php echo $ep['faixas']; ?> <?php echo translateText('faixas'); ?></span>
                                <span>•</span>
                                <span><?php echo $ep['streams']; ?> streams</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </section>

        <!-- Singles -->
        <section class="release-section" data-type="singles">
            <h2 class="section-title"><?php echo translateText('Singles'); ?></h2>
            <section class="releases-grid">
                <?php foreach ($discografia['singles'] as $single): ?>
                    <article class="release-card" data-id="<?php echo $single['id']; ?>">
                        <div class="release-actions">
                            <button class="btn-icon" onclick="editRelease(<?php echo $single['id']; ?>, 'single')" title="Editar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="btn-icon btn-danger" onclick="deleteRelease(<?php echo $single['id']; ?>, 'single')" title="Excluir">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                        <div class="release-cover" onclick="viewRelease(<?php echo $single['id']; ?>, 'single')">
                            <img src="<?php echo $single['capa']; ?>" alt="<?php echo htmlspecialchars($single['titulo']); ?>">
                        </div>
                        <div class="release-info">
                            <span class="release-badge badge-purple"><?php echo $single['tipo']; ?></span>
                            <h3><?php echo htmlspecialchars($single['titulo']); ?></h3>
                            <p class="release-year"><?php echo $single['ano']; ?></p>
                            <div class="release-meta">
                                <span><?php echo $single['streams']; ?> streams</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'dashboardArtDiscografia.php',
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

            // Filtros
            const filterTabs = document.querySelectorAll('.filter-tab');
            const releaseSections = document.querySelectorAll('.release-section');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    filterTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    const filter = tab.dataset.filter;
                    
                    releaseSections.forEach(section => {
                        if (filter === 'all') {
                            section.style.display = 'block';
                        } else {
                            section.style.display = section.dataset.type === filter ? 'block' : 'none';
                        }
                    });
                });
            });
        });

        function viewRelease(id, type) {
            window.location.href = `detalhesLancamento.php?id=${id}&type=${type}&lang=<?php echo $currentLang; ?>`;
        }

        function editRelease(id, type) {
            window.location.href = `editarLancamento.php?id=${id}&type=${type}&lang=<?php echo $currentLang; ?>`;
        }

        function deleteRelease(id, type) {
            if (confirm('<?php echo translateText('Tem certeza que deseja excluir este lançamento?'); ?>')) {
                // Implementar exclusão
                console.log(`Excluir ${type} com ID ${id}`);
            }
        }

        document.getElementById('btnAddRelease').addEventListener('click', () => {
            window.location.href = 'formCadMusica.php?lang=<?php echo $currentLang; ?>';
        });
    </script>
</body>
</html>