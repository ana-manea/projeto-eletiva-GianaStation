<?php
require_once 'config.php';
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

$artist_id = $_SESSION['artist_id'];
$pageTitle = translateText('Discografia');

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

// Verificar se as tabelas existem
$conexao = conectarBD();
$result = mysqli_query($conexao, "SHOW TABLES LIKE 'lancamentos'");
$tabela_lancamentos_existe = mysqli_num_rows($result) > 0;
fecharConexao($conexao);

// Buscar todos os lançamentos
$lancamentos = [];
if ($tabela_lancamentos_existe) {
    $lancamentos = buscarTodosLancamentos($artist_id);
}

// Separar por tipo
$albums = [];
$eps = [];
$singles = [];

foreach ($lancamentos as $lancamento) {
    if ($lancamento['Tipo'] == 'Álbum') {
        $albums[] = $lancamento;
    } elseif ($lancamento['Tipo'] == 'EP') {
        $eps[] = $lancamento;
    } elseif ($lancamento['Tipo'] == 'Single') {
        $singles[] = $lancamento;
    }
}

// Codificar para JavaScript
$lancamentosJson = json_encode($lancamentos);
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <link rel="stylesheet" href="../css/style-dashboardArtDiscografia.css">
    <title><?php echo $pageTitle; ?> | Giana Station for Artists</title>
</head>
<body>
    <nav class="navbar">
        <section class="navbar-content">
            <section class="navbar-left">
                <a href="dashboardArtista.php" class="artist-profile">
                    <section class="artist-avatar">
                        <img src="<?php echo !empty($foto_perfil) ? htmlspecialchars($foto_perfil) : 'https://via.placeholder.com/100'; ?>" alt="<?php echo htmlspecialchars($artista['Nome_artistico']); ?>">
                    </section>
                    <section class="artist-info">
                        <h2><?php echo htmlspecialchars($artista['Nome_artistico']); ?></h2>
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
        <?php if (!$tabela_lancamentos_existe): ?>
            <div class="alert alert-info" style="background: rgba(74, 144, 226, 0.1); border: 1px solid rgba(74, 144, 226, 0.3); border-radius: 8px; padding: 1rem; margin-bottom: 2rem;">
                <p style="margin: 0; color: #4a90e2;">
                    <strong>ℹ️ Configuração Inicial:</strong> Para visualizar lançamentos, execute o script SQL fornecido no README.
                </p>
            </div>
        <?php endif; ?>

        <section class="page-header">
            <div>
                <h1><?php echo translateText('Discografia'); ?></h1>
                <p><?php echo translateText('Gerencie seus álbuns, EPs e singles'); ?></p>
            </div>
        </section>

        <section class="stats-overview" id="statsOverview">
            <section class="stat-card">
                <div class="stat-icon-wrapper stat-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-value"><?php echo count($albums); ?></p>
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
                    <p class="stat-value"><?php echo count($eps); ?></p>
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
                    <p class="stat-value"><?php echo count($singles); ?></p>
                    <p class="stat-label"><?php echo translateText('Singles'); ?></p>
                </div>
            </section>
        </section>

        <!-- Filtros -->
        <section class="filter-tabs">
            <button class="filter-tab active" data-filter="all"><?php echo translateText('Todos'); ?></button>
            <button class="filter-tab" data-filter="Álbum"><?php echo translateText('Álbuns'); ?></button>
            <button class="filter-tab" data-filter="EP"><?php echo translateText('EPs'); ?></button>
            <button class="filter-tab" data-filter="Single"><?php echo translateText('Singles'); ?></button>
        </section>

        <!-- Grid de Lançamentos -->
        <section class="releases-grid" id="releasesContainer">
            <?php if (!empty($lancamentos)): ?>
                <?php foreach ($lancamentos as $lancamento): ?>
                    <article class="release-card" data-tipo="<?php echo htmlspecialchars($lancamento['Tipo']); ?>">
                        <div class="release-cover" onclick="window.location.href='detalhesLancamento.php?id=<?php echo $lancamento['ID_Lancamento']; ?>&lang=<?php echo $currentLang; ?>'">
                            <img src="<?php echo htmlspecialchars($lancamento['Capa_path']); ?>" alt="<?php echo htmlspecialchars($lancamento['Titulo']); ?>">
                        </div>
                        <div class="release-info">
                            <span class="release-badge <?php 
                                echo $lancamento['Tipo'] == 'EP' ? 'badge-blue' : 
                                     ($lancamento['Tipo'] == 'Single' ? 'badge-purple' : ''); 
                            ?>"><?php echo htmlspecialchars($lancamento['Tipo']); ?></span>
                            <h3><?php echo htmlspecialchars($lancamento['Titulo']); ?></h3>
                            <p class="release-year"><?php echo $lancamento['Ano']; ?></p>
                            <div class="release-meta">
                                <span><?php echo $lancamento['Total_faixas']; ?> <?php echo translateText('faixas'); ?></span>
                                <?php if ($lancamento['Total_streams'] > 0): ?>
                                    <span>•</span>
                                    <span><?php echo formatarNumero($lancamento['Total_streams']); ?> streams</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; text-align: center; color: rgba(255,255,255,0.6); padding: 3rem;">
                    <?php echo translateText('Nenhum lançamento cadastrado ainda.'); ?>
                    <br><br>
                    <a href="cadastrarMusica.php?lang=<?php echo $currentLang; ?>" style="color: #1db954; text-decoration: underline;">
                        <?php echo translateText('Adicione seu primeiro lançamento'); ?>
                    </a>
                </p>
            <?php endif; ?>
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
        // Filtros
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const releaseCards = document.querySelectorAll('.release-card');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remover active de todos
                    filterTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    const filter = tab.dataset.filter;
                    
                    // Filtrar cards
                    releaseCards.forEach(card => {
                        if (filter === 'all') {
                            card.style.display = 'block';
                        } else {
                            const tipo = card.dataset.tipo;
                            card.style.display = tipo === filter ? 'block' : 'none';
                        }
                    });
                });
            });
            
            setupMobileMenu();
        });

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

        function setupMobileMenu() {
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
        }
    </script>
</body>
</html>