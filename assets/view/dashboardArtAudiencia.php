<?php
require_once 'config.php';
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

$artist_id = $_SESSION['artist_id'];
$pageTitle = translateText('Audiência');

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
$tabelas_existem = true;
$tabelas = ['estatisticas_artista', 'top_musicas_artista', 'demografia_pais', 'demografia_idade'];
foreach ($tabelas as $tabela) {
    $result = mysqli_query($conexao, "SHOW TABLES LIKE '$tabela'");
    if (mysqli_num_rows($result) == 0) {
        $tabelas_existem = false;
        break;
    }
}
fecharConexao($conexao);

// Buscar dados se as tabelas existirem
$stats = null;
$top_musicas = [];
$paises = [];
$faixas_idade = [];

if ($tabelas_existem) {
    $stats = buscarEstatisticasArtista($artist_id);
    $top_musicas = buscarTopMusicasArtista($artist_id, 3);
    $paises = buscarDemografiaPais($artist_id, 3);
    $faixas_idade = buscarDemografiaIdade($artist_id);
}

// Valores padrão se não houver dados
if (!$stats) {
    $stats = [
        'Total_streams' => 0,
        'Ouvintes_mensais' => 0,
        'Crescimento_streams_percentual' => 0,
        'Crescimento_ouvintes_percentual' => 0
    ];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <link rel="stylesheet" href="../css/style-dashboardArtAudiencia.css">
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
                    <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Discografia'); ?></a>
                    <a href="dashboardArtAudiencia.php?lang=<?php echo $currentLang; ?>" class="nav-link active"><?php echo translateText('Audiência'); ?></a>
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
        <?php if (!$tabelas_existem): ?>
            <div class="alert alert-info" style="background: rgba(74, 144, 226, 0.1); border: 1px solid rgba(74, 144, 226, 0.3); border-radius: 8px; padding: 1rem; margin-bottom: 2rem;">
                <p style="margin: 0; color: #4a90e2;">
                    <strong>ℹ️ Configuração Inicial:</strong> Para visualizar métricas de audiência, execute o script SQL fornecido no README.
                </p>
            </div>
        <?php endif; ?>

        <section class="page-header">
            <h1><?php echo translateText('Audiência'); ?></h1>
            <p><?php echo translateText('Acompanhe o desempenho das suas músicas e entenda seu público'); ?></p>
        </section>

        <section class="stats-grid">
            <section class="stat-card stat-primary">
                <section class="stat-header">
                    <p><?php echo translateText('Total de Streams'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </section>
                <p class="stat-value"><?php echo formatarNumero($stats['Total_streams']); ?></p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo formatarPercentual($stats['Crescimento_streams_percentual']); ?> <?php echo translateText('vs semana passada'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-blue">
                <section class="stat-header">
                    <p><?php echo translateText('Ouvintes Únicos'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </section>
                <p class="stat-value"><?php echo formatarNumero($stats['Ouvintes_mensais']); ?></p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo formatarPercentual($stats['Crescimento_ouvintes_percentual']); ?> <?php echo translateText('vs semana passada'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-purple">
                <section class="stat-header">
                    <p><?php echo translateText('Saves'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                </section>
                <p class="stat-value">1.8K</p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span>+24.3% <?php echo translateText('vs semana passada'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-accent">
                <section class="stat-header">
                    <p><?php echo translateText('Taxa de Conclusão'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                </section>
                <p class="stat-value">78%</p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span>+3.2% <?php echo translateText('vs semana passada'); ?></span>
                </p>
            </section>
        </section>

        <section class="content-grid">
            <section class="content-main">
                <section class="card">
                    <h2><?php echo translateText('Top Músicas'); ?></h2>
                    <section class="top-songs-list">
                        <?php if (!empty($top_musicas)): ?>
                            <?php foreach ($top_musicas as $musica): ?>
                                <section class="song-item">
                                    <span class="song-position"><?php echo $musica['Posicao']; ?></span>
                                    <section class="song-info">
                                        <p class="song-title"><?php echo htmlspecialchars($musica['Titulo']); ?></p>
                                        <section class="song-details">
                                            <span><?php echo htmlspecialchars($musica['Album']); ?></span>
                                            <span>•</span>
                                            <span><?php echo $musica['Ano']; ?></span>
                                        </section>
                                    </section>
                                    <p class="song-streams"><?php echo formatarNumero($musica['Total_streams']); ?></p>
                                    <span class="song-change positive">
                                        <span class="song-change-text positive">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                                <polyline points="17 6 23 6 23 12"/>
                                            </svg>
                                            <?php echo formatarPercentual($musica['Crescimento_percentual']); ?>
                                        </span>
                                    </span>
                                </section>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: rgba(255,255,255,0.6); padding: 2rem;">
                                <?php echo translateText('Configure as estatísticas para ver suas músicas mais populares.'); ?>
                            </p>
                        <?php endif; ?>
                    </section>
                </section>
            </section>

            <section class="content-sidebar">
                <section class="card">
                    <h2><?php echo translateText('Países (Top Ouvintes)'); ?></h2>
                    <section class="countries-list">
                        <?php if (!empty($paises)): ?>
                            <?php foreach ($paises as $pais): ?>
                                <section class="country-item">
                                    <section class="country-header">
                                        <span class="country-name">
                                            <span class="country-flag"><?php echo $pais['Emoji_bandeira']; ?></span>
                                            <?php echo htmlspecialchars($pais['Pais']); ?>
                                        </span>
                                        <span class="country-percentage"><?php echo number_format($pais['Percentual'], 0); ?>%</span>
                                    </section>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo $pais['Percentual']; ?>%"></div>
                                    </div>
                                    <p class="country-listeners"><?php echo formatarNumero($pais['Total_ouvintes']); ?> <?php echo translateText('ouvintes'); ?></p>
                                </section>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: rgba(255,255,255,0.6); padding: 2rem;">
                                <?php echo translateText('Dados demográficos serão exibidos após a configuração.'); ?>
                            </p>
                        <?php endif; ?>
                    </section>
                </section>

                <section class="card">
                    <h2><?php echo translateText('Faixa Etária'); ?></h2>
                    <section class="demographics-list">
                        <?php if (!empty($faixas_idade)): ?>
                            <?php foreach ($faixas_idade as $faixa): ?>
                                <section class="demo-item">
                                    <section class="demo-header">
                                        <span class="demo-age"><?php echo htmlspecialchars($faixa['Faixa_etaria']); ?></span>
                                        <span class="demo-percentage"><?php echo number_format($faixa['Percentual'], 0); ?>%</span>
                                    </section>
                                    <div class="progress-bar">
                                        <div class="progress-fill blue" style="width: <?php echo $faixa['Percentual']; ?>%"></div>
                                    </div>
                                    <p class="demo-count"><?php echo formatarNumero($faixa['Total_ouvintes']); ?> <?php echo translateText('ouvintes'); ?></p>
                                </section>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: rgba(255,255,255,0.6); padding: 2rem;">
                                <?php echo translateText('Dados demográficos serão exibidos após a configuração.'); ?>
                            </p>
                        <?php endif; ?>
                    </section>
                </section>
            </section>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'dashboardArtAudiencia.php',
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