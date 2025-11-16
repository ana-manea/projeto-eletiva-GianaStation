<?php
require_once 'config.php';

// Dados do lançamento (exemplo)
$lancamento = [
    'id' => 3,
    'titulo' => 'Esquinas',
    'ano' => 2024,
    'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
    'tipo' => 'Álbum',
    'gravadora' => 'Universal Music',
    'descricao' => 'O terceiro álbum de estúdio da dupla traz 12 faixas inéditas que exploram novas sonoridades mantendo a essência da MPB.',
    'musicas' => [
        ['id' => 1, 'numero' => 1, 'titulo' => 'Esquinas', 'duracao' => '3:45', 'streams' => '450K', 'destaque' => true],
        ['id' => 2, 'numero' => 2, 'titulo' => 'Singular', 'duracao' => '4:02', 'streams' => '320K', 'destaque' => false],
        ['id' => 3, 'numero' => 3, 'titulo' => 'Seu Olhar', 'duracao' => '3:28', 'streams' => '280K', 'destaque' => false],
        ['id' => 4, 'numero' => 4, 'titulo' => 'Deixa Estar', 'duracao' => '3:55', 'streams' => '245K', 'destaque' => false],
        ['id' => 5, 'numero' => 5, 'titulo' => 'Versos', 'duracao' => '4:12', 'streams' => '198K', 'destaque' => false],
        ['id' => 6, 'numero' => 6, 'titulo' => 'Na Palma da Mão', 'duracao' => '3:38', 'streams' => '175K', 'destaque' => false],
        ['id' => 7, 'numero' => 7, 'titulo' => 'Refúgio', 'duracao' => '4:25', 'streams' => '162K', 'destaque' => false],
        ['id' => 8, 'numero' => 8, 'titulo' => 'Acalanto', 'duracao' => '3:15', 'streams' => '148K', 'destaque' => false],
        ['id' => 9, 'numero' => 9, 'titulo' => 'Alvorada', 'duracao' => '3:52', 'streams' => '135K', 'destaque' => false],
        ['id' => 10, 'numero' => 10, 'titulo' => 'Encontros', 'duracao' => '4:08', 'streams' => '122K', 'destaque' => false],
        ['id' => 11, 'numero' => 11, 'titulo' => 'Caminho', 'duracao' => '3:42', 'streams' => '110K', 'destaque' => false],
        ['id' => 12, 'numero' => 12, 'titulo' => 'Recomeço', 'duracao' => '4:30', 'streams' => '98K', 'destaque' => false]
    ]
];

$totalDuracao = 0;
foreach ($lancamento['musicas'] as $musica) {
    list($min, $sec) = explode(':', $musica['duracao']);
    $totalDuracao += ($min * 60) + $sec;
}
$totalMin = floor($totalDuracao / 60);

$pageTitle = $lancamento['titulo'];
?>

<link rel="stylesheet" href="../css/style-detalhesLancamento.css">

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

    <!-- Header do Álbum -->
    <section class="album-header">
        <div class="album-background" style="background-image: url('<?php echo $lancamento['capa']; ?>')"></div>
        <div class="album-overlay"></div>
        
        <div class="album-content">
            <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                <span><?php echo translateText('Voltar à Discografia'); ?></span>
            </a>
            
            <div class="album-info-wrapper">
                <div class="album-cover">
                    <img src="<?php echo $lancamento['capa']; ?>" alt="<?php echo htmlspecialchars($lancamento['titulo']); ?>">
                </div>
                
                <div class="album-details">
                    <span class="album-type"><?php echo $lancamento['tipo']; ?></span>
                    <h1 class="album-title"><?php echo htmlspecialchars($lancamento['titulo']); ?></h1>
                    <div class="album-meta">
                        <span><?php echo $lancamento['ano']; ?></span>
                        <span>•</span>
                        <span><?php echo count($lancamento['musicas']); ?> <?php echo translateText('faixas'); ?></span>
                        <span>•</span>
                        <span><?php echo $totalMin; ?> min</span>
                    </div>
                    <p class="album-description"><?php echo htmlspecialchars($lancamento['descricao']); ?></p>
                    
                    <div class="album-actions">
                        <button class="btn-primary" onclick="editAlbum(<?php echo $lancamento['id']; ?>)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            <span><?php echo translateText('Editar Álbum'); ?></span>
                        </button>
                        <button class="btn-secondary" id="btnAddTrack">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            <span><?php echo translateText('Adicionar Música'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lista de Músicas -->
    <main class="main-content">
        <section class="tracks-section">
            <div class="tracks-header">
                <div class="track-col-number">#</div>
                <div class="track-col-title"><?php echo translateText('Título'); ?></div>
                <div class="track-col-duration"><?php echo translateText('Duração'); ?></div>
                <div class="track-col-streams"><?php echo translateText('Streams'); ?></div>
                <div class="track-col-actions"></div>
            </div>
            
            <div class="tracks-list">
                <?php foreach ($lancamento['musicas'] as $musica): ?>
                    <div class="track-item <?php echo $musica['destaque'] ? 'track-highlight' : ''; ?>" data-id="<?php echo $musica['id']; ?>">
                        <div class="track-col-number">
                            <span class="track-number"><?php echo $musica['numero']; ?></span>
                            <button class="track-play">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="5 3 19 12 5 21 5 3"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="track-col-title">
                            <div class="track-info">
                                <span class="track-title"><?php echo htmlspecialchars($musica['titulo']); ?></span>
                                <?php if ($musica['destaque']): ?>
                                    <span class="track-badge"><?php echo translateText('Destaque'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="track-col-duration">
                            <span><?php echo $musica['duracao']; ?></span>
                        </div>
                        
                        <div class="track-col-streams">
                            <span><?php echo $musica['streams']; ?></span>
                        </div>
                        
                        <div class="track-col-actions">
                            <button class="track-action-btn" onclick="editTrack(<?php echo $musica['id']; ?>)" title="Editar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="track-action-btn track-delete" onclick="deleteTrack(<?php echo $musica['id']; ?>)" title="Excluir">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'detalhesLancamento.php',
        'preserveParams' => ['id', 'type']
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

        function editAlbum(id) {
            window.location.href = `editarLancamento.php?id=${id}&lang=<?php echo $currentLang; ?>`;
        }

        function editTrack(id) {
            window.location.href = `editarMusica.php?id=${id}&lang=<?php echo $currentLang; ?>`;
        }

        function deleteTrack(id) {
            if (confirm('<?php echo translateText('Tem certeza que deseja excluir esta música?'); ?>')) {
                console.log('Excluir música:', id);
            }
        }

        document.getElementById('btnAddTrack').addEventListener('click', () => {
            window.location.href = 'formCadMusica.php?album=<?php echo $lancamento['id']; ?>&lang=<?php echo $currentLang; ?>';
        });
    </script>
</body>
</html>