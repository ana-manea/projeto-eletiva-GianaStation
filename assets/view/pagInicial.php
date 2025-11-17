<?php
require_once 'config.php';
require_once '../processamento/funcoesBD.php';

// Verificar se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

// Buscar dados do usuário
$usuario = buscarUsuarioID($_SESSION['user_id']);

if (!$usuario) {
    session_destroy();
    header('Location: login.php?lang=' . $currentLang);
    exit;
}

// Buscar artistas populares
$artistas_populares = buscarArtistasPopulares(4);

// Buscar músicas recentes
$musicas_recentes = buscarMusicasRecentes(8);

// Buscar playlists do usuário
$playlists_usuario = listarPlaylistsUsuario($_SESSION['user_id']);

// Preparar dados para exibição
$pageTitle = $usuario['Nome'];

// Verificar se tem foto de perfil
$foto_perfil = !empty($usuario['Foto_perfil']) ? $usuario['Foto_perfil'] : '../img/sem-foto.png';
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Giana Station</title>
    <link rel="stylesheet" href="../css/style-padrao.css">
    <link rel="stylesheet" href="../css/style-pagInicial.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header">
        <nav class="top-menu">
            <img src="../img/GA-Station.png" alt="Giana Station">
            
            <section>
                <a href="pagInicial.php?lang=<?php echo $currentLang; ?>">
                    <button id="home">
                        <svg data-encore-id="icon" role="img" aria-hidden="true" viewBox="0 0 24 24">
                            <path d="M13.5 1.515a3 3 0 0 0-3 0L3 5.845a2 2 0 0 0-1 1.732V21a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6h4v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V7.577a2 2 0 0 0-1-1.732z"></path>
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

    <section class="conteudo">
        <!-- Menu Lateral -->
        <aside class="lateral-menu">
            <section class="lateral-menu-top">
                <h3><?php echo translateText('Sua Biblioteca'); ?></h3>
                <a href="cadastrarPlaylist.php?lang=<?php echo $currentLang; ?>">
                    <button id="criar-playlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="16" height="16">
                            <path d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                        <?php echo translateText('Criar'); ?>
                    </button>
                </a>
            </section>

            <?php if (empty($playlists_usuario)): ?>
            <section class="lateral-menu-content sem-playlist">
                <h3><?php echo translateText('Crie sua primeira playlist'); ?></h3>
                <p><?php echo translateText('É fácil, vamos te ajudar.'); ?></p>
                <button onclick="window.location.href='cadastrarPlaylist.php?lang=<?php echo $currentLang; ?>'"><?php echo translateText('Criar Playlist'); ?></button>
            </section>
            <?php else: ?>
            <section class="lateral-menu-content">
                <?php foreach ($playlists_usuario as $playlist): ?>
                    <article class="playlist-item" onclick="window.location.href='#'">
                        <img src="<?php echo !empty($playlist['Capa_play_path']) ? htmlspecialchars($playlist['Capa_play_path']) : '../img/playlist-default.png'; ?>" alt="<?php echo htmlspecialchars($playlist['Nome_playlist']); ?>">
                        <div>
                            <h4><?php echo htmlspecialchars($playlist['Nome_playlist']); ?></h4>
                            <p><?php echo translateText('Playlist'); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
        </aside>

        <section class="principal">
            <!-- Artistas Mais Tocados -->
            <?php if (!empty($artistas_populares)): ?>
            <section class="cards">
                <article class="albuns-titulo">
                    <article>
                        <h1><?php echo translateText('Artistas populares'); ?></h1>
                        <p><?php echo translateText('Descubra novos artistas'); ?></p>
                    </article>
                </article>

                <section class="albuns">
                    <?php foreach ($artistas_populares as $artista): ?>
                        <section class="card" onclick="window.location.href='visualizarArtista.php?id=<?php echo $artista['ID_Artista']; ?>&lang=<?php echo $currentLang; ?>'">
                            <article class="card-img">
                                <img src="<?php echo htmlspecialchars($artista['Capa_path']); ?>" alt="<?php echo htmlspecialchars($artista['Nome_artistico']); ?>">
                                <button class="card-play-btn" onclick="event.stopPropagation();">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                    </svg>
                                </button>
                            </article>
                            <article class="nome-categoria">
                                <p class="nome"><?php echo htmlspecialchars($artista['Nome_artistico']); ?></p>
                                <p class="categoria"><?php echo translateText('Artista'); ?></p>
                            </article>
                        </section>
                    <?php endforeach; ?>
                </section>
            </section>
            <?php endif; ?>

            <!-- Músicas Populares -->
            <?php if (!empty($musicas_recentes)): ?>
            <section class="cards">
                <article class="albuns-titulo">
                    <article>
                        <h1><?php echo translateText('Músicas recentes'); ?></h1>
                        <p><?php echo translateText('Novidades para você'); ?></p>
                    </article>
                </article>

                <section class="albuns">
                    <?php foreach (array_slice($musicas_recentes, 0, 4) as $musica): ?>
                        <section class="card" onclick="window.location.href='verMusica.php?id=<?php echo $musica['ID_Musica']; ?>&lang=<?php echo $currentLang; ?>'">
                            <article class="card-img musica">
                                <img src="<?php echo htmlspecialchars(!empty($musica['Capa_mus_path']) ? $musica['Capa_mus_path'] : '../img/sem-capa.png'); ?>" alt="<?php echo htmlspecialchars($musica['Titulo']); ?>">
                                <button class="card-play-btn" onclick="event.stopPropagation();">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                    </svg>
                                </button>
                            </article>
                            <article class="nome-categoria">
                                <p class="nome"><?php echo htmlspecialchars($musica['Titulo']); ?></p>
                                <p class="categoria"><?php echo htmlspecialchars($musica['Nome_artistico']); ?></p>
                            </article>
                        </section>
                    <?php endforeach; ?>
                </section>
            </section>
            <?php endif; ?>

            <!-- Recomendações -->
            <?php if (!empty($musicas_recentes) && count($musicas_recentes) > 4): ?>
            <section class="cards">
                <article class="albuns-titulo">
                    <article>
                        <h1><?php echo translateText('Recomendado para você'); ?></h1>
                        <p><?php echo translateText('Com base nos seus artistas favoritos'); ?></p>
                    </article>
                </article>

                <section class="albuns">
                    <?php foreach (array_slice($musicas_recentes, 4, 4) as $musica): ?>
                        <section class="card" onclick="window.location.href='verMusica.php?id=<?php echo $musica['ID_Musica']; ?>&lang=<?php echo $currentLang; ?>'">
                            <article class="card-img musica">
                                <img src="<?php echo htmlspecialchars(!empty($musica['Capa_mus_path']) ? $musica['Capa_mus_path'] : '../img/sem-capa.png'); ?>" alt="<?php echo htmlspecialchars($musica['Titulo']); ?>">
                                <button class="card-play-btn" onclick="event.stopPropagation();">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"/>
                                    </svg>
                                </button>
                            </article>
                            <article class="nome-categoria">
                                <p class="nome"><?php echo htmlspecialchars($musica['Titulo']); ?></p>
                                <p class="categoria"><?php echo htmlspecialchars($musica['Nome_artistico']); ?></p>
                            </article>
                        </section>
                    <?php endforeach; ?>
                </section>
            </section>
            <?php endif; ?>
        </section>
    </section>

    <?php
    $modalConfig = [
        'returnUrl' => 'pagInicial.php',
        'preserveParams' => []
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
                <a href="homePaginaCadastro.php"><p>Para Artistas</p></a>
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
                console.log('Menu toggled:', menu.classList.contains('active'));
            } else {
                console.error('Menu não encontrado');
            }
        }

        // Fechar menu ao clicar fora
        document.addEventListener('click', function(e) {
            const perfilBtn = document.querySelector('.perfil-btn');
            const perfil = document.getElementById('perfil');
            const menu = document.getElementById('perfil-menu-suspenso');
            
            // Se clicou fora do botão e do menu
            if (menu && perfilBtn && !perfilBtn.contains(e.target)) {
                menu.classList.remove('active');
            }
        });

        // Adicionar listener direto no botão também
        document.addEventListener('DOMContentLoaded', function() {
            const perfilBtn = document.getElementById('perfil');
            if (perfilBtn) {
                perfilBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    interagirMenuPerfil();
                });
                console.log('Event listener adicionado ao botão perfil');
            } else {
                console.error('Botão perfil não encontrado');
            }
        });

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