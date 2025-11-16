<?php
require_once 'config.php';

// Obter ID do artista da URL
$artistId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Dados do artista (exemplo - substituir por dados do banco)
$artistas = [
    1 => [
        'id' => 1,
        'nome' => 'AnaVitória',
        'verificado' => true,
        'avatar' => 'https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4',
        'capa' => 'https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4',
        'foto_perfil' => 'https://image-cdn-ak.spotifycdn.com/image/ab6761860000101685ec2d2af58d2b838a744ac4',
        'seguidores' => 21201,
        'bio' => 'ANAVITÓRIA é uma dupla musical brasileira formada por Ana Caetano e Vitória Falcão. Naturais de Araguaína, Tocantins, iniciaram a carreira em 2015 e rapidamente conquistaram o público brasileiro com letras sobre amor e autodescoberta.',
        'generos' => ['MPB', 'Pop', 'Folk-pop'],
        'redes_sociais' => [
            'instagram' => '@anavitoria',
            'twitter' => '@oanavitoria',
            'tiktok' => '@asanavitoria',
            'website' => 'https://www.asanavitoria.com'
        ],
        'musicas_populares' => [
            ['id' => 1, 'titulo' => 'Trevo (Tu)', 'album' => 'Trevo', 'duracao' => '3:45', 'streams' => '450K'],
            ['id' => 2, 'titulo' => 'Singular', 'album' => 'Esquinas', 'duracao' => '4:02', 'streams' => '320K'],
            ['id' => 3, 'titulo' => 'Esquinas', 'album' => 'Esquinas', 'duracao' => '3:38', 'streams' => '280K'],
            ['id' => 4, 'titulo' => 'Não Sinto Nada', 'album' => 'Trevo', 'duracao' => '3:28', 'streams' => '245K'],
            ['id' => 5, 'titulo' => 'Tempo', 'album' => 'O Tempo É Agora', 'duracao' => '3:52', 'streams' => '210K']
        ],
        'discografia' => [
            ['id' => 1, 'titulo' => 'Trevo', 'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50', 'ano' => 2017, 'tipo' => 'Álbum'],
            ['id' => 2, 'titulo' => 'O Tempo É Agora', 'capa' => 'https://i.scdn.co/image/ab67616d0000b2735d7cf1a8508aa994d4bde5c8', 'ano' => 2018, 'tipo' => 'Álbum'],
            ['id' => 3, 'titulo' => 'Esquinas', 'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd', 'ano' => 2024, 'tipo' => 'Álbum']
        ]
    ]
];

$artista = $artistas[$artistId] ?? $artistas[1];
$pageTitle = $artista['nome'];
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo $pageTitle; ?> | Giana Station</title>
    <link rel="stylesheet" href="../css/style-padrao.css">
    <link rel="stylesheet" href="../css/style-visualizarArtista.css">
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
            <!-- Hero Section -->
            <section class="artist-hero">
                <div class="hero-background" style="background-image: url('<?php echo htmlspecialchars($artista['capa']); ?>')"></div>
                <div class="hero-overlay"></div>
                
                <section class="infos">
                    <?php if ($artista['verificado']): ?>
                        <h3 class="verificado">
                            <svg viewBox="0 0 24 24" style="fill: #4cb3ff; width: 1.5rem; height: 1.5rem; position: relative; background-image: linear-gradient(#fff, #fff); background-size: 50% 50%; background-position: center center; background-repeat: no-repeat;">
                                <title>Verified account</title>
                                <path d="M10.814.5a1.66 1.66 0 0 1 2.372 0l2.512 2.572 3.595-.043a1.66 1.66 0 0 1 1.678 1.678l-.043 3.595 2.572 2.512c.667.65.667 1.722 0 2.372l-2.572 2.512.043 3.595a1.66 1.66 0 0 1-1.678 1.678l-3.595-.043-2.512 2.572a1.66 1.66 0 0 1-2.372 0l-2.512-2.572-3.595.043a1.66 1.66 0 0 1-1.678-1.678l.043-3.595L.5 13.186a1.66 1.66 0 0 1 0-2.372l2.572-2.512-.043-3.595a1.66 1.66 0 0 1 1.678-1.678l3.595.043zm6.584 9.12a1 1 0 0 0-1.414-1.413l-6.011 6.01-1.894-1.893a1 1 0 0 0-1.414 1.414l3.308 3.308z"></path>
                            </svg>
                            <?php echo translateText('Artista verificado'); ?>
                        </h3>
                    <?php endif; ?>
                    <h1 class="nome-artista"><?php echo htmlspecialchars($artista['nome']); ?></h1>
                    <h2 class="seguidores"><?php echo number_format($artista['seguidores'], 0, ',', '.'); ?> <?php echo translateText('seguidores'); ?></h2>
                </section>
            </section>

            <!-- Botões de Interação -->
            <section class="artist-actions">
                <button class="btn-play" title="<?php echo translateText('Reproduzir'); ?>">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                    </svg>
                </button>
                <button class="btn-follow" id="followBtn">
                    <?php echo translateText('Seguir'); ?>
                </button>
                <button class="btn-share" title="<?php echo translateText('Compartilhar'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="18" cy="5" r="3"/>
                        <circle cx="6" cy="12" r="3"/>
                        <circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                </button>
            </section>

            <!-- Músicas Populares -->
            <section class="popular-section">
                <h2><?php echo translateText('Populares'); ?></h2>
                <table class="tracks-table">
                    <tbody>
                        <?php foreach ($artista['musicas_populares'] as $index => $musica): ?>
                            <tr class="track-row" data-track-id="<?php echo $musica['id']; ?>">
                                <td class="track-number">
                                    <span class="number"><?php echo $index + 1; ?></span>
                                    <button class="play-btn" title="<?php echo translateText('Reproduzir'); ?>">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                        </svg>
                                    </button>
                                </td>
                                <td class="track-title">
                                    <div class="track-info">
                                        <p class="title"><?php echo htmlspecialchars($musica['titulo']); ?></p>
                                        <p class="artist"><?php echo htmlspecialchars($artista['nome']); ?></p>
                                    </div>
                                </td>
                                <td class="track-album"><?php echo htmlspecialchars($musica['album']); ?></td>
                                <td class="track-actions">
                                    <button class="btn-like" data-track-id="<?php echo $musica['id']; ?>" title="<?php echo translateText('Curtir'); ?>">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>
                                </td>
                                <td class="track-duration"><?php echo $musica['duracao']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!-- Discografia -->
            <section class="discography-section">
                <div class="section-header">
                    <h2><?php echo translateText('Discografia'); ?></h2>
                    <a href="#" class="link-show-all"><?php echo translateText('Mostrar tudo'); ?></a>
                </div>
                <div class="albums-grid">
                    <?php foreach ($artista['discografia'] as $album): ?>
                        <article class="album-card" onclick="window.location.href='detalhesLancamento.php?id=<?php echo $album['id']; ?>&type=album&lang=<?php echo $currentLang; ?>'">
                            <div class="album-cover">
                                <img src="<?php echo htmlspecialchars($album['capa']); ?>" alt="<?php echo htmlspecialchars($album['titulo']); ?>">
                                <button class="album-play-btn" onclick="event.stopPropagation();" title="<?php echo translateText('Reproduzir'); ?>">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="album-info">
                                <h3><?php echo htmlspecialchars($album['titulo']); ?></h3>
                                <p><?php echo $album['ano']; ?> • <?php echo translateText($album['tipo']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Sobre o Artista -->
            <section class="sobre">
                <h3><?php echo translateText('Sobre'); ?></h3>

                <div class="sobre-content">
                    <section class="descri-foto">
                        <img src="<?php echo htmlspecialchars($artista['foto_perfil']); ?>" alt="<?php echo htmlspecialchars($artista['nome']); ?>">
                        <article class="fundo-descricao">
                            <p id="descricao"><?php echo htmlspecialchars($artista['bio']); ?></p>
                        </article>
                    </section>

                    <section class="midia-infos">
                        <article class="seguidores">
                            <h3 id="seguidores"><?php echo number_format($artista['seguidores'], 0, ',', '.'); ?></h3>
                            <p><?php echo translateText('seguidores'); ?></p>
                        </article>
                        
                        <?php if (isset($artista['redes_sociais']['instagram'])): ?>
                        <a href="https://instagram.com/<?php echo ltrim($artista['redes_sociais']['instagram'], '@'); ?>" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 3.803c2.67 0 2.986.01 4.041.059.975.044 1.504.207 1.857.344.435.16.828.416 1.151.748.332.323.588.716.748 1.151.137.353.3.882.345 1.857.047 1.055.058 1.37.058 4.041 0 2.67-.01 2.986-.058 4.041-.045.975-.208 1.505-.345 1.857A3.32 3.32 0 0 1 17.9 19.8c-.352.137-.882.3-1.856.344-1.055.048-1.371.058-4.041.058s-2.987-.01-4.041-.058c-.975-.044-1.505-.207-1.857-.344a3.1 3.1 0 0 1-1.151-.748 3.1 3.1 0 0 1-.749-1.151c-.137-.353-.3-.883-.344-1.857-.048-1.055-.058-1.371-.058-4.041s.01-2.987.058-4.041c.045-.975.207-1.505.344-1.857a3.1 3.1 0 0 1 .749-1.151 3.1 3.1 0 0 1 1.15-.749c.353-.137.883-.3 1.858-.344 1.054-.048 1.37-.058 4.04-.058zM12.002 2c-2.716 0-3.057.012-4.124.06-1.066.05-1.793.22-2.428.466A4.9 4.9 0 0 0 3.678 3.68a4.9 4.9 0 0 0-1.153 1.772c-.247.635-.416 1.363-.465 2.427C2.012 8.943 2 9.286 2 12.002c0 2.715.012 3.056.06 4.123.05 1.066.218 1.791.465 2.426a4.9 4.9 0 0 0 1.153 1.772c.5.508 1.105.902 1.772 1.153.635.248 1.363.417 2.428.465s1.407.06 4.123.06 3.056-.01 4.123-.06 1.79-.217 2.426-.465a5.1 5.1 0 0 0 2.925-2.925c.247-.635.416-1.363.465-2.427.048-1.064.06-1.407.06-4.123s-.012-3.057-.06-4.123c-.05-1.067-.218-1.791-.465-2.426a4.9 4.9 0 0 0-1.153-1.771 4.9 4.9 0 0 0-1.772-1.155c-.635-.247-1.363-.416-2.428-.464s-1.406-.06-4.122-.06z"></path>
                                <path d="M12 6.867a5.135 5.135 0 1 0 0 10.27 5.135 5.135 0 0 0 0-10.27m0 8.47a3.334 3.334 0 1 1 0-6.67 3.334 3.334 0 0 1 0 6.67m5.338-7.473a1.2 1.2 0 1 0 0-2.4 1.2 1.2 0 0 0 0 2.4"></path>
                            </svg>
                            <p>Instagram</p>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($artista['redes_sociais']['twitter'])): ?>
                        <a href="https://twitter.com/<?php echo ltrim($artista['redes_sociais']['twitter'], '@'); ?>" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 16 16">
                                <path d="M13.54 3.889a2.97 2.97 0 0 0 1.333-1.683 6 6 0 0 1-1.929.738 3 3 0 0 0-.996-.706 3 3 0 0 0-1.218-.254 2.92 2.92 0 0 0-2.143.889 2.93 2.93 0 0 0-.889 2.15q0 .318.08.691a8.5 8.5 0 0 1-3.484-.932A8.5 8.5 0 0 1 1.532 2.54a3 3 0 0 0-.413 1.523q0 .778.361 1.445.36.668.988 1.08a2.9 2.9 0 0 1-1.373-.374v.04q0 1.088.69 1.92a2.97 2.97 0 0 0 1.739 1.048 2.94 2.94 0 0 1-1.365.056 2.94 2.94 0 0 0 1.063 1.5 2.95 2.95 0 0 0 1.77.603 5.94 5.94 0 0 1-3.77 1.302q-.365 0-.722-.048A8.4 8.4 0 0 0 5.15 14q1.358 0 2.572-.361 1.215-.36 2.147-.988a9 9 0 0 0 1.683-1.46q.75-.834 1.234-1.798a9.5 9.5 0 0 0 .738-1.988 8.4 8.4 0 0 0 .246-2.429 6.2 6.2 0 0 0 1.508-1.563q-.84.373-1.738.476"></path>
                            </svg>
                            <p>Twitter</p>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($artista['redes_sociais']['tiktok'])): ?>
                        <a href="https://tiktok.com/<?php echo ltrim($artista['redes_sociais']['tiktok'], '@'); ?>" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 2a4.313 4.313 0 0 0 4.313 4.313v2a6.296 6.296 0 0 1-4.688-2.085v8.864c-.008 2.092-.671 3.85-1.82 5.098-1.159 1.257-2.758 1.935-4.492 1.935a6.312 6.312 0 1 1 0-12.625v2a4.313 4.313 0 0 0 0 8.625c1.199 0 2.256-.46 3.02-1.29.767-.832 1.292-2.096 1.292-3.781V2H17z"></path>
                            </svg>
                            <p>TikTok</p>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($artista['redes_sociais']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($artista['redes_sociais']['website']); ?>" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 16 16">
                                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z"></path>
                                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"></path>
                            </svg>
                            <p><?php echo translateText('Site'); ?></p>
                        </a>
                        <?php endif; ?>
                    </section>
                </div>
            </section>
        </section>
    </main>

    <?php
    $modalConfig = [
        'returnUrl' => 'visualizarArtista.php',
        'preserveParams' => ['id']
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
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"></path>
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

        // Botão seguir
        const followBtn = document.getElementById('followBtn');
        if (followBtn) {
            followBtn.addEventListener('click', function() {
                const isFollowing = this.classList.contains('following');
                
                if (isFollowing) {
                    this.textContent = '<?php echo translateText('Seguir'); ?>';
                    this.classList.remove('following');
                } else {
                    this.textContent = '<?php echo translateText('Seguindo'); ?>';
                    this.classList.add('following');
                }
            });
        }

        // Play nas linhas da tabela
        document.querySelectorAll('.track-row').forEach(row => {
            const playBtn = row.querySelector('.play-btn');
            const number = row.querySelector('.number');
            
            row.addEventListener('mouseenter', () => {
                if (number) number.style.display = 'none';
                if (playBtn) playBtn.style.display = 'block';
            });
            
            row.addEventListener('mouseleave', () => {
                if (number) number.style.display = 'block';
                if (playBtn) playBtn.style.display = 'none';
            });
            
            // Simular reprodução ao clicar na linha ou botão play
            const handlePlay = (e) => {
                e.stopPropagation();
                const trackId = row.dataset.trackId;
                console.log('Reproduzindo música ID:', trackId);
                // Aqui você implementaria a lógica real de reprodução
                alert('Reproduzindo música...');
            };
            
            if (playBtn) {
                playBtn.addEventListener('click', handlePlay);
            }
        });

        // Curtir músicas
        document.querySelectorAll('.btn-like').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const trackId = this.dataset.trackId;
                this.classList.toggle('liked');
                
                const svg = this.querySelector('svg');
                if (this.classList.contains('liked')) {
                    svg.setAttribute('fill', '#d518ee');
                    svg.setAttribute('stroke', 'none');
                    console.log('Música curtida ID:', trackId);
                    // Aqui você salvaria no banco de dados
                } else {
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', 'currentColor');
                    console.log('Música descurtida ID:', trackId);
                    // Aqui você removeria do banco de dados
                }
            });
        });

        // Botão de compartilhar
        const shareBtn = document.querySelector('.btn-share');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const artistName = '<?php echo addslashes($artista['nome']); ?>';
                const url = window.location.href;
                
                if (navigator.share) {
                    navigator.share({
                        title: artistName,
                        text: `Confira ${artistName} na Giana Station`,
                        url: url
                    }).catch(err => console.log('Erro ao compartilhar:', err));
                } else {
                    // Fallback: copiar link
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copiado para a área de transferência!');
                    });
                }
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