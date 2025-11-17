<?php
require_once 'config.php';
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado e é artista
if (!isset($_SESSION['user_id']) || !isset($_SESSION['artist_id'])) {
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

$artist_id = $_SESSION['artist_id'];
$pageTitle = 'Dashboard';

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

// Buscar estatísticas (com verificação se existe)
$stats = null;
$conexao = conectarBD();
$result = mysqli_query($conexao, "SHOW TABLES LIKE 'estatisticas_artista'");
$tabela_existe = mysqli_num_rows($result) > 0;
fecharConexao($conexao);

if ($tabela_existe) {
    $stats = buscarEstatisticasArtista($artist_id);
}

// Se não existir estatísticas, usar valores padrão
if (!$stats) {
    $stats = [
        'Total_streams' => 0,
        'Ouvintes_mensais' => 0,
        'Total_lancamentos' => 0,
        'Total_seguidores' => 0,
        'Crescimento_streams_percentual' => 0,  
        'Crescimento_ouvintes_percentual' => 0, 
        'Crescimento_seguidores' => 0
    ];
}

// Buscar performance (com verificação)
$performance_7dias = null;
$performance_28dias = null;
if ($tabela_existe) {
    $performance_7dias = buscarPerformanceArtista($artist_id, '7_dias');
    $performance_28dias = buscarPerformanceArtista($artist_id, '28_dias');
}

// Buscar lançamentos (verificar se tabela existe)
$lancamentos_recentes = [];
$conexao = conectarBD();
$result = mysqli_query($conexao, "SHOW TABLES LIKE 'lancamentos'");
$tabela_lancamentos_existe = mysqli_num_rows($result) > 0;
fecharConexao($conexao);

if ($tabela_lancamentos_existe) {
    $lancamentos_recentes = buscarLancamentosRecentes($artist_id, 3);
}

// Buscar top músicas (verificar se tabela existe)
$top_musicas = [];
$conexao = conectarBD();
$result = mysqli_query($conexao, "SHOW TABLES LIKE 'top_musicas_artista'");
$tabela_top_existe = mysqli_num_rows($result) > 0;
fecharConexao($conexao);

if ($tabela_top_existe) {
    $top_musicas = buscarTopMusicasArtista($artist_id, 3);
}

// Buscar contagem de lançamentos
$contagem_lancamentos = ['singles' => 0, 'eps' => 0, 'albums' => 0];
if ($tabela_lancamentos_existe) {
    $contagem_lancamentos = contarLancamentosPorTipo($artist_id);
}
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
                    <a href="dashboardArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link active"><?php echo translate('home'); ?></a>
                    <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translateText('Discografia'); ?></a>
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

    <section class="hero-section">
        <section class="hero-background" style="background-image: url('<?php echo !empty($artista['Capa_path']) ? htmlspecialchars($artista['Capa_path']) : 'https://via.placeholder.com/1920x400'; ?>')"></section>
        <section class="hero-overlay"></section>
        <section class="hero-content">
            <section class="hero-profile">
                <section class="hero-avatar">
                    <img src="<?php echo !empty($foto_perfil) ? htmlspecialchars($foto_perfil) : 'https://via.placeholder.com/200'; ?>" alt="<?php echo htmlspecialchars($artista['Nome_artistico']); ?>">
                </section>
                <section class="hero-info">
                    <span class="badge-verified">
                        <svg viewBox="0 0 24 24" fill="#4cb3ff" style="width:20px;">
                            <path d="M10.814.5a1.66 1.66 0 0 1 2.372 0l2.512 2.572 3.595-.043a1.66 1.66 0 0 1 1.678 1.678l-.043 3.595 2.572 2.512c.667.65.667 1.722 0 2.372l-2.572 2.512.043 3.595a1.66 1.66 0 0 1-1.678 1.678l-3.595-.043-2.512 2.572a1.66 1.66 0 0 1-2.372 0l-2.512-2.572-3.595.043a1.66 1.66 0 0 1-1.678-1.678l.043-3.595L.5 13.186a1.66 1.66 0 0 1 0-2.372l2.572-2.512-.043-3.595a1.66 1.66 0 0 1 1.678-1.678l3.595.043zm6.584 9.12a1 1 0 0 0-1.414-1.413l-6.011 6.01-1.894-1.893a1 1 0 0 0-1.414 1.414l3.308 3.308z"/>
                        </svg>
                        <?php echo translateText('Artista verificado'); ?>
                    </span>
                    <h1><?php echo htmlspecialchars($artista['Nome_artistico']); ?></h1>
                    <p><?php echo formatarNumero($stats['Ouvintes_mensais']); ?> <?php echo translateText('ouvintes mensais'); ?></p>
                </section>
            </section>
        </section>
    </section>

    <main class="main-content">
        <?php if (!$tabela_existe): ?>
            <div class="alert alert-info" style="background: rgba(74, 144, 226, 0.1); border: 1px solid rgba(74, 144, 226, 0.3); border-radius: 8px; padding: 1rem; margin-bottom: 2rem;">
                <p style="margin: 0; color: #4a90e2;">
                    <strong>ℹ️ Configuração Inicial:</strong> Para visualizar estatísticas completas, execute o script SQL fornecido no README.
                </p>
            </div>
        <?php endif; ?>

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
                <p class="stat-value"><?php echo formatarNumero($stats['Total_streams']); ?></p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo formatarPercentual($stats['Crescimento_streams_percentual']); ?> <?php echo translateText('este mês'); ?></span>
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
                <p class="stat-value"><?php echo formatarNumero($stats['Ouvintes_mensais']); ?></p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span><?php echo formatarPercentual($stats['Crescimento_ouvintes_percentual']); ?> <?php echo translateText('este mês'); ?></span>
                </p>
            </section>

            <section class="stat-card stat-purple">
                <section class="stat-header">
                    <p><?php echo translateText('Lançamentos'); ?></p>
                    <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </section>
                <p class="stat-value"><?php echo $stats['Total_lancamentos']; ?></p>
                <p class="stat-change neutral">
                    <span>
                        <?php echo $contagem_lancamentos['singles']; ?> singles, 
                        <?php echo $contagem_lancamentos['eps']; ?> EPs, 
                        <?php echo $contagem_lancamentos['albums']; ?> álbuns
                    </span>
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
                <p class="stat-value"><?php echo formatarNumero($stats['Total_seguidores']); ?></p>
                <p class="stat-change positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        <polyline points="17 6 23 6 23 12"/>
                    </svg>
                    <span>+<?php echo $stats['Crescimento_seguidores']; ?> <?php echo translateText('esta semana'); ?></span>
                </p>
            </section>
        </section>

        <section class="content-grid">
            <section class="content-left">
                <section class="section">
                    <section class="section-header">
                        <h2><?php echo translateText('Lançamentos Recentes'); ?></h2>
                        <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" class="link-primary"><?php echo translateText('Ver todos'); ?></a>
                    </section>
                    <section class="releases-grid">
                        <?php if (!empty($lancamentos_recentes)): ?>
                            <?php foreach ($lancamentos_recentes as $lancamento): ?>
                                <article class="release-card" onclick="window.location.href='detalhesLancamento.php?id=<?php echo $lancamento['ID_Lancamento']; ?>&lang=<?php echo $currentLang; ?>'">
                                    <div class="release-cover">
                                        <img src="<?php echo htmlspecialchars($lancamento['Capa_path']); ?>" alt="<?php echo htmlspecialchars($lancamento['Titulo']); ?>">
                                    </div>
                                    <div class="release-info">
                                        <span class="release-badge"><?php echo htmlspecialchars($lancamento['Tipo']); ?></span>
                                        <h3><?php echo htmlspecialchars($lancamento['Titulo']); ?></h3>
                                        <p class="release-year"><?php echo $lancamento['Ano']; ?></p>
                                        <p class="release-streams"><?php echo formatarNumero($lancamento['Total_streams']); ?> streams</p>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: rgba(255,255,255,0.6);">Nenhum lançamento cadastrado. <a href="dashboardArtDiscografia.php?lang=<?php echo $currentLang; ?>" style="color: #1db954;">Adicione seu primeiro lançamento</a></p>
                        <?php endif; ?>
                    </section>
                </section>

                <section class="section">
                    <section class="card">
                        <h2><?php echo translateText('Visão Geral de Performance'); ?></h2>
                        <section class="performance-list">
                            <?php if ($performance_7dias): ?>
                                <section class="performance-item">
                                    <div>
                                        <p class="performance-label"><?php echo translateText('Últimos 7 dias'); ?></p>
                                        <p class="performance-value"><?php echo number_format($performance_7dias['Total_streams'], 0, ',', '.'); ?></p>
                                        <p class="performance-unit"><?php echo translateText('streams'); ?></p>
                                    </div>
                                    <section class="performance-change positive">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                            <polyline points="17 6 23 6 23 12"/>
                                        </svg>
                                        <span><?php echo formatarPercentual($performance_7dias['Crescimento_percentual']); ?></span>
                                    </section>
                                </section>
                            <?php else: ?>
                                <p style="color: rgba(255,255,255,0.6); text-align: center; padding: 2rem;">
                                    Dados de performance serão exibidos após a configuração inicial do banco de dados.
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($performance_28dias): ?>
                                <section class="performance-item">
                                    <div>
                                        <p class="performance-label"><?php echo translateText('Últimos 28 dias'); ?></p>
                                        <p class="performance-value"><?php echo number_format($performance_28dias['Total_streams'], 0, ',', '.'); ?></p>
                                        <p class="performance-unit"><?php echo translateText('streams'); ?></p>
                                    </div>
                                    <section class="performance-change positive">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                            <polyline points="17 6 23 6 23 12"/>
                                        </svg>
                                        <span><?php echo formatarPercentual($performance_28dias['Crescimento_percentual']); ?></span>
                                    </section>
                                </section>
                            <?php endif; ?>
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
                        <section class="top-songs-list">
                            <?php if (!empty($top_musicas)): ?>
                                <?php foreach ($top_musicas as $musica): ?>
                                    <section class="song-item">
                                        <span class="song-position"><?php echo $musica['Posicao']; ?></span>
                                        <section class="song-info">
                                            <p class="song-title"><?php echo htmlspecialchars($musica['Titulo']); ?></p>
                                            <p class="song-streams"><?php echo formatarNumero($musica['Total_streams']); ?> streams</p>
                                        </section>
                                    </section>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: rgba(255,255,255,0.6); text-align: center; padding: 2rem;">
                                    Configure as estatísticas para ver suas músicas mais populares.
                                </p>
                            <?php endif; ?>
                        </section>
                    </section>
                </section>

                <section class="section">
                    <section class="card card-gradient">
                        <h2><?php echo translateText('Informações do Artista'); ?></h2>
                        <section class="artist-info-list">
                            <section class="info-item">
                                <p class="info-label"><?php echo translateText('Gêneros'); ?></p>
                                <p class="info-value"><?php echo htmlspecialchars($artista['Genero_art'] ?? 'Não especificado'); ?></p>
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