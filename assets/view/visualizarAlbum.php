<?php
require_once 'config.php';

// Obter ID do álbum da URL
$albumId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : 'album';

// Dados do álbum (exemplo - substituir por dados do banco)
$albums = [
    1 => [
        'id' => 1,
        'titulo' => 'Trevo',
        'artista' => 'AnaVitória',
        'artista_id' => 1,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
        'ano' => 2017,
        'tipo' => 'Álbum',
        'duracao_total' => '45:23',
        'total_faixas' => 12,
        'gravadora' => 'Universal Music',
        'cor_dominante' => '#8B4513',
        'faixas' => [
            ['id' => 1, 'numero' => 1, 'titulo' => 'Trevo (Tu)', 'duracao' => '3:45', 'explicit' => false],
            ['id' => 2, 'numero' => 2, 'titulo' => 'Não Sinto Nada', 'duracao' => '3:28', 'explicit' => false],
            ['id' => 3, 'numero' => 3, 'titulo' => 'Mesma Tela', 'duracao' => '3:52', 'explicit' => false],
            ['id' => 4, 'numero' => 4, 'titulo' => 'Agora Eu Quero Ir', 'duracao' => '4:15', 'explicit' => false],
            ['id' => 5, 'numero' => 5, 'titulo' => 'Você Sempre Será', 'duracao' => '3:33', 'explicit' => false],
            ['id' => 6, 'numero' => 6, 'titulo' => 'Tudo Que Eu Quero', 'duracao' => '3:48', 'explicit' => false],
            ['id' => 7, 'numero' => 7, 'titulo' => 'É Isso Aí', 'duracao' => '4:02', 'explicit' => false],
            ['id' => 8, 'numero' => 8, 'titulo' => 'Não Precisa', 'duracao' => '3:25', 'explicit' => false],
            ['id' => 9, 'numero' => 9, 'titulo' => 'Eu Sei', 'duracao' => '3:55', 'explicit' => false],
            ['id' => 10, 'numero' => 10, 'titulo' => 'Não Sou Forte', 'duracao' => '4:10', 'explicit' => false],
            ['id' => 11, 'numero' => 11, 'titulo' => 'Eu Vou', 'duracao' => '3:38', 'explicit' => false],
            ['id' => 12, 'numero' => 12, 'titulo' => 'Final', 'duracao' => '3:32', 'explicit' => false]
        ]
    ],
    2 => [
        'id' => 2,
        'titulo' => 'O Tempo É Agora',
        'artista' => 'AnaVitória',
        'artista_id' => 1,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b2735d7cf1a8508aa994d4bde5c8',
        'ano' => 2018,
        'tipo' => 'Álbum',
        'duracao_total' => '42:15',
        'total_faixas' => 11,
        'gravadora' => 'Universal Music',
        'cor_dominante' => '#4A5568',
        'faixas' => [
            ['id' => 13, 'numero' => 1, 'titulo' => 'Tempo', 'duracao' => '3:52', 'explicit' => false],
            ['id' => 14, 'numero' => 2, 'titulo' => 'Fica', 'duracao' => '3:45', 'explicit' => false],
            ['id' => 15, 'numero' => 3, 'titulo' => 'Trem-Bala', 'duracao' => '4:12', 'explicit' => false],
            ['id' => 16, 'numero' => 4, 'titulo' => 'Greve', 'duracao' => '3:28', 'explicit' => false],
            ['id' => 17, 'numero' => 5, 'titulo' => 'Nada Vem de Graça', 'duracao' => '3:55', 'explicit' => false],
            ['id' => 18, 'numero' => 6, 'titulo' => 'Memórias', 'duracao' => '4:08', 'explicit' => false],
            ['id' => 19, 'numero' => 7, 'titulo' => 'Papel', 'duracao' => '3:38', 'explicit' => false],
            ['id' => 20, 'numero' => 8, 'titulo' => 'Lisboa', 'duracao' => '3:42', 'explicit' => false],
            ['id' => 21, 'numero' => 9, 'titulo' => 'S de Saudade', 'duracao' => '4:25', 'explicit' => false],
            ['id' => 22, 'numero' => 10, 'titulo' => 'Clarice', 'duracao' => '3:48', 'explicit' => false],
            ['id' => 23, 'numero' => 11, 'titulo' => 'Agora', 'duracao' => '3:22', 'explicit' => false]
        ]
    ],
    3 => [
        'id' => 3,
        'titulo' => 'Esquinas',
        'artista' => 'AnaVitória',
        'artista_id' => 1,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
        'ano' => 2024,
        'tipo' => 'Álbum',
        'duracao_total' => '38:47',
        'total_faixas' => 10,
        'gravadora' => 'Universal Music',
        'cor_dominante' => '#2D3748',
        'faixas' => [
            ['id' => 24, 'numero' => 1, 'titulo' => 'Singular', 'duracao' => '4:02', 'explicit' => false],
            ['id' => 25, 'numero' => 2, 'titulo' => 'Esquinas', 'duracao' => '3:38', 'explicit' => false],
            ['id' => 26, 'numero' => 3, 'titulo' => 'Nada', 'duracao' => '3:55', 'explicit' => false],
            ['id' => 27, 'numero' => 4, 'titulo' => 'Promete', 'duracao' => '4:12', 'explicit' => false],
            ['id' => 28, 'numero' => 5, 'titulo' => 'Água', 'duracao' => '3:28', 'explicit' => false],
            ['id' => 29, 'numero' => 6, 'titulo' => 'Caminho', 'duracao' => '3:45', 'explicit' => false],
            ['id' => 30, 'numero' => 7, 'titulo' => 'Horizonte', 'duracao' => '4:08', 'explicit' => false],
            ['id' => 31, 'numero' => 8, 'titulo' => 'Reflexo', 'duracao' => '3:32', 'explicit' => false],
            ['id' => 32, 'numero' => 9, 'titulo' => 'Madrugada', 'duracao' => '4:25', 'explicit' => false],
            ['id' => 33, 'numero' => 10, 'titulo' => 'Encerramento', 'duracao' => '3:42', 'explicit' => false]
        ]
    ]
];

$album = $albums[$albumId] ?? $albums[1];
$pageTitle = $album['titulo'] . ' - ' . $album['artista'];
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo $pageTitle; ?> | Giana Station</title>
    <link rel="stylesheet" href="../css/style-padrao.css">
    <link rel="stylesheet" href="../css/style-visualizarAlbum.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header">
        <nav class="top-menu">
            <img src="../img/GA-Station.png" alt="Giana Station">
            
            <section>
                <a href="pagInicial.php?lang=<?php echo $currentLang; ?>">
                    <button id="home">
                        <svg viewBox="0 0 24 24">
                            <path d="M12.5 3.247a1 1 0 0 0-1 0L4 7.577V20h4.5v-6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v6H20V7.577zm-2-1.732a3 3 0 0 1 3 0l7.5 4.33a2 2 0 0 1 1 1.732V21a1 1 0 0 1-1 1h-6.5a1 1 0 0 1-1-1v-6h-3v6a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.577a2 2 0 0 1 1-1.732z"></path>
                        </svg>
                    </button>
                </a>
                
                <form action="#" method="GET">
                    <input type="hidden" name="lang" value="<?php echo $currentLang; ?>">
                    <label for="pesquisa-inicio">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                        </svg>
                    </label>
                    <input type="text" placeholder="<?php echo translateText('O que você deseja ouvir?'); ?>" name="q" id="pesquisa-inicio">
                </form>
            </section>

            <section>
                <button class="btn-notification">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"></path>
                    </svg>
                </button>
                
                <?php
                $buttonConfig = [
                    'position' => 'relative',
                    'showText' => false,
                    'style' => ''
                ];
                require_once 'languageBtn.php';
                ?>
                
                <section class="perfil-btn">
                    <button id="perfil" onclick="interagirMenuPerfil()">
                        <img src="../img/sem-foto.png" alt="Perfil">
                    </button>
                    <ul id="perfil-menu-suspenso">
                        <a href="perfilUsuario.php?lang=<?php echo $currentLang; ?>"><li><?php echo translateText('Perfil'); ?></li></a>
                        <div></div>
                        <a href="index.php?lang=<?php echo $currentLang; ?>"><li id="sair"><?php echo translateText('Sair'); ?></li></a>
                    </ul>
                </section>
            </section>
        </nav>
    </header>

    <main class="content">
        <!-- Sidebar -->
        <aside class="sidebar">
            <section class="sidebar-header">
                <h3><?php echo translateText('Sua Biblioteca'); ?></h3>
            </section>
            
            <section class="sidebar-empty">
                <h3><?php echo translateText('Suas músicas favoritas aparecerão aqui'); ?></h3>
                <p><?php echo translateText('Comece a curtir músicas para vê-las na sua biblioteca.'); ?></p>
            </section>
        </aside>

        <!-- Conteúdo Principal -->
        <section class="main-content">
            <!-- Hero Section do Álbum -->
            <section class="album-hero" style="background: linear-gradient(180deg, <?php echo $album['cor_dominante']; ?> 0%, var(--background-card) 100%);">
                <div class="hero-content">
                    <div class="album-cover-large">
                        <img src="<?php echo htmlspecialchars($album['capa']); ?>" alt="<?php echo htmlspecialchars($album['titulo']); ?>">
                    </div>
                    
                    <div class="album-info">
                        <p class="album-type"><?php echo translateText($album['tipo']); ?></p>
                        <h1 class="album-title"><?php echo htmlspecialchars($album['titulo']); ?></h1>
                        <div class="album-meta">
                            <a href="visualizarArtista.php?id=<?php echo $album['artista_id']; ?>&lang=<?php echo $currentLang; ?>" class="artist-link">
                                <?php echo htmlspecialchars($album['artista']); ?>
                            </a>
                            <span class="separator">•</span>
                            <span><?php echo $album['ano']; ?></span>
                            <span class="separator">•</span>
                            <span><?php echo $album['total_faixas']; ?> <?php echo translateText('músicas'); ?></span>
                            <span class="separator">•</span>
                            <span><?php echo $album['duracao_total']; ?></span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Controles -->
            <section class="album-controls">
                <button class="btn-play-large" title="<?php echo translateText('Reproduzir'); ?>">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                    </svg>
                </button>
                
                <button class="btn-save" id="saveBtn" title="<?php echo translateText('Salvar na sua biblioteca'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                </button>
                
                <button class="btn-more" title="<?php echo translateText('Mais opções'); ?>">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="5" r="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="12" cy="19" r="2"/>
                    </svg>
                </button>
            </section>

            <!-- Lista de Faixas -->
            <section class="tracks-section">
                <div class="tracks-header">
                    <div class="track-header-number">#</div>
                    <div class="track-header-title"><?php echo translateText('Título'); ?></div>
                    <div class="track-header-duration">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                    </div>
                </div>

                <div class="tracks-list">
                    <?php foreach ($album['faixas'] as $faixa): ?>
                        <div class="track-item" data-track-id="<?php echo $faixa['id']; ?>">
                            <div class="track-number">
                                <span class="number"><?php echo $faixa['numero']; ?></span>
                                <button class="play-btn-small" title="<?php echo translateText('Reproduzir'); ?>">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="track-info">
                                <div class="track-title">
                                    <?php echo htmlspecialchars($faixa['titulo']); ?>
                                    <?php if ($faixa['explicit']): ?>
                                        <span class="explicit-badge">E</span>
                                    <?php endif; ?>
                                </div>
                                <div class="track-artist"><?php echo htmlspecialchars($album['artista']); ?></div>
                            </div>
                            
                            <div class="track-actions">
                                <button class="btn-like-small" data-track-id="<?php echo $faixa['id']; ?>" title="<?php echo translateText('Curtir'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="track-duration"><?php echo $faixa['duracao']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Informações do Álbum -->
            <section class="album-details">
                <p class="release-date"><?php echo date('d/m/Y', strtotime($album['ano'] . '-01-01')); ?></p>
                <p class="label">© <?php echo $album['ano']; ?> <?php echo htmlspecialchars($album['gravadora']); ?></p>
            </section>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'visualizarAlbum.php',
        'preserveParams' => ['id', 'type']
    ];
    require_once 'languageModal.php';
    ?>

    <footer class="rodape">
        <section class="top">
            <section>
                <h4><?php echo translate('useful_links'); ?></h4>
                <p><?php echo translate('about'); ?></p>
                <p>Empregos</p>
                <p>For the Record</p>
            </section>
    
            <section>
                <h4>Comunidades</h4>
                <a href="page2.php?lang=<?php echo $currentLang; ?>"><p>Para Artistas</p></a>
                <p>Desenvolvedores</p>
                <p>Publicidade</p>
                <p>Investidores</p>
                <p>Fornecedores</p>
            </section>
    
            <section>
                <h4>Links úteis</h4>
                <p>Suporte</p>
                <p>Aplicativo móvel grátis</p>
                <p>Popular por país</p>
                <p>Import your music</p>
            </section>
    
            <section>
                <h4>Planos do Giana Station</h4>
                <p>Premium Individual</p>
                <p>Premium Duo</p>
                <p>Premium Família</p>
                <p>Premium Universitário</p>
                <p>Giana Station Free</p>
            </section>
            
            <section class="redes">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"></path>
                    </svg>
                </button>

                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057a3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"></path>
                    </svg>
                </button>
                
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
                    </svg>
                </button>
            </section>
        </section>

        <section class="bottom">
            <article>
                <p><?php echo translate('legal'); ?></p>
                <p>Segurança e Centro de privacidade</p>
                <p><?php echo translate('privacy'); ?></p>
                <p><?php echo translate('cookies'); ?></p>
                <p>Sobre anúncios</p>
                <p>Acessibilidade</p>
            </article>
            
            <article class="direitos">
                <p>© 2025 Giana Station AB</p>
            </article>
        </section>
    </footer>

    <script>
        // Menu do perfil
        function interagirMenuPerfil() {
            const menu = document.getElementById('perfil-menu-suspenso');
            if (menu) {
                menu.classList.toggle('active');
            }
        }

        // Fechar menu ao clicar fora
        document.addEventListener('click', function(e) {
            const perfil = document.getElementById('perfil');
            const menu = document.getElementById('perfil-menu-suspenso');
            
            if (menu && perfil && !perfil.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('active');
            }
        });

        // Botão de salvar álbum
        const saveBtn = document.getElementById('saveBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function() {
                const isSaved = this.classList.contains('saved');
                
                if (isSaved) {
                    this.classList.remove('saved');
                    this.querySelector('svg').setAttribute('fill', 'none');
                    console.log('Álbum removido da biblioteca');
                } else {
                    this.classList.add('saved');
                    this.querySelector('svg').setAttribute('fill', 'currentColor');
                    console.log('Álbum salvo na biblioteca');
                }
            });
        }

        // Play nas faixas
        document.querySelectorAll('.track-item').forEach(item => {
            const playBtn = item.querySelector('.play-btn-small');
            const number = item.querySelector('.number');
            
            item.addEventListener('mouseenter', () => {
                if (number) number.style.display = 'none';
                if (playBtn) playBtn.style.display = 'flex';
            });
            
            item.addEventListener('mouseleave', () => {
                if (number) number.style.display = 'block';
                if (playBtn) playBtn.style.display = 'none';
            });
            
            // Reproduzir ao clicar
            const handlePlay = (e) => {
                e.stopPropagation();
                const trackId = item.dataset.trackId;
                console.log('Reproduzindo música ID:', trackId);
                alert('Reproduzindo música...');
            };
            
            if (playBtn) {
                playBtn.addEventListener('click', handlePlay);
            }
            
            // Clicar na linha inteira também reproduz
            item.addEventListener('click', handlePlay);
        });

        // Curtir músicas
        document.querySelectorAll('.btn-like-small').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const trackId = this.dataset.trackId;
                this.classList.toggle('liked');
                
                const svg = this.querySelector('svg');
                if (this.classList.contains('liked')) {
                    svg.setAttribute('fill', '#d518ee');
                    svg.setAttribute('stroke', 'none');
                    console.log('Música curtida ID:', trackId);
                } else {
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', 'currentColor');
                    console.log('Música descurtida ID:', trackId);
                }
            });
        });

        // Botão de play grande
        const playLargeBtn = document.querySelector('.btn-play-large');
        if (playLargeBtn) {
            playLargeBtn.addEventListener('click', function() {
                console.log('Reproduzindo álbum completo');
                alert('Reproduzindo álbum...');
            });
        }

        // Language Modal
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
    </script>
</body>
</html>