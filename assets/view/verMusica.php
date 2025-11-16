<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giana Station</title>
    
    <!-- CSS Comuns -->
    <link rel="stylesheet" href="../css/style-cabecalho.css">
    <link rel="stylesheet" href="../css/style-menusSuspenso-Lateral.css">
    <link rel="stylesheet" href="../css/style-cardsMusica.css">
    <link rel="stylesheet" href="../css/style-rodape.css">
    
    <!-- CSS da Página -->
    <link rel="stylesheet" href="../css/style-visualizarMusica.css">

    
    <script>
        let abertoPerfil = false;

        function interagirMenuPerfil()
        {
            abertoPerfil = !abertoPerfil;
            if (abertoPerfil)
                document.getElementById('perfil-menu-suspenso').classList.add('aberto');

            else
                document.getElementById('perfil-menu-suspenso').classList.remove('aberto');
        }
    </script>
</head>
<body>
    <header>
        <nav class="top-menu">
            <img src="../img/GA-Station.png"> <!--Ícone GianaStation-->
            <section>

                <!-- Home ícone sem preencher -->
                <a href="pagInicial.php">
                    <button id="home">
                        <svg viewBox="0 0 24 24"><path d="M12.5 3.247a1 1 0 0 0-1 0L4 7.577V20h4.5v-6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v6H20V7.577zm-2-1.732a3 3 0 0 1 3 0l7.5 4.33a2 2 0 0 1 1 1.732V21a1 1 0 0 1-1 1h-6.5a1 1 0 0 1-1-1v-6h-3v6a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.577a2 2 0 0 1 1-1.732z"></path>
                        </svg>
                    </button> 
                </a>

                <form>
                    <label for="pesquisa-inicio">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg> <!--Ícone Pesquisar-->
                    </label>
                    <input type="text" placeholder="O que você deseja ouvir?" name="pesquisa" id="pesquisa-inicio">
                    <button><img></button> <!--Ícone Navegar-->
                </form>
            </section>

            <section>
                <button> <!--Notificações-->
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                    </svg>
                </button>
    
                <section class="perfil-btn">
                    <button id="perfil" onclick="interagirMenuPerfil()">
                        <img>
                    </button> <!--Perfil/Conta -->
                    <ul id="perfil-menu-suspenso">
                        <a href="perfilUsuario.php"><li>Perfil</li></a>
                        <div></div>
                        <a href="login.php"><li id="sair">Sair</li></a>
                    </ul>
                </section>
            </section>
        </nav>
    </header>

    <section class="conteudo">
        <aside class="lateral-menu"> <!-- Menu lateral-->
            <section class="lateral-menu-top">
                <h3>Sua Biblioteca</h3>
                <a href="cadPlaylist.php">
                    <button id="criar-playlist">
                        Criar
                    </button>
                </a>
            </section>

            <section class="lateral-menu-content sem-playlist">
                <h3>Crie sua primeira playlist</h3>
                <p>É fácil, vamos te ajudar.</p>
                <button>Criar Playlist</button>
            </section>
        </aside>

        <section class="principal"> <!-- Principal -->
            <section class="infos"> <!-- Infos -->
                <section class="espacoFoto">
                    <article>
                        <img src="../img/capas-albums/capa-alina-pluto.jpg" id="foto-perfil">
                    </article>
                </section>


                <section class="dados">
                    <p>Single</p>
                    <h1>Pluto</h1>
                    <section class="alinhados">
                        <article class="artista" id="artista">
                            <img src="../img/foto-perfil/alina-foto.jpg">
                            <a><p id="nome-artista">Alina Simpson</p></a>
                        </article>
                        <div></div>
                        <p>Piano</p>
                    </section>
                </section>
            </section>

            <section class="tabela-secao">
                <table class="lista-musicas">
                    <thead>
                        <tr>
                            <th class="num-lista">#</th>
                            <th class="musica-lista">Título</th>
                            <th class="album-lista">Álbum</th>
                            <th class="artista-lista">Artista</th>
                            <th class="duracao-lista">Duração</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="num-lista">
                                1
                                <svg viewBox="0 0 24 24">
                                    <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"></path>
                                </svg>
                            </td>
                            <td class="musica-lista">Pluto</td>
                            <td class="album-lista">Pluto</td>
                            <td class="artista-lista"><a>Alina Simpson</a></td>
                            <td class="add-musica-lista" role="button">
                                <svg viewBox="0 0 16 16">
                                    <path d="M8 1.5a6.5 6.5 0 1 0 0 13 6.5 6.5 0 0 0 0-13M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8"></path><path d="M11.75 8a.75.75 0 0 1-.75.75H8.75V11a.75.75 0 0 1-1.5 0V8.75H5a.75.75 0 0 1 0-1.5h2.25V5a.75.75 0 0 1 1.5 0v2.25H11a.75.75 0 0 1 .75.75"></path>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="num-lista">
                                2
                                <svg viewBox="0 0 24 24">
                                    <path d="m7.05 3.606 13.49 7.788a.7.7 0 0 1 0 1.212L7.05 20.394A.7.7 0 0 1 6 19.788V4.212a.7.7 0 0 1 1.05-.606"></path>
                                </svg>
                            </td>
                            <td class="musica-lista">Pluto</td>
                            <td class="album-lista">Pluto</td>
                            <td class="artista-lista"><a>Alina Simpson</a></td>
                            <td class="musica-adicionada-lista" role="button">
                                <svg viewBox="0 0 16 16">
                                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m11.748-1.97a.75.75 0 0 0-1.06-1.06l-4.47 4.47-1.405-1.406a.75.75 0 1 0-1.061 1.06l2.466 2.467 5.53-5.53z"></path>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="cards"> <!--2o Carrossel-->
                <article class="albuns-titulo">
                    <!--Título-->
                    <h1>Recomendado</h1>
                </article>

                <section class="albuns">
                    <!--Álbuns-->
                    <a href="verMusica.php">
                        <section class="card">
                            <article class="card-img">
                                <img src="../img/capas-albums/capa-berlinist-neva.jpg">
                            </article>
    
                            <article class="nome-categoria">
                                <p class="nome">In courage abide</p>
                                <p class="categoria">Berlinist</p>
                            </article>
                        </section>
                    </a>
                </section>
            </section>
            
        </section>

    </section>

    <footer class="rodape">
        <section class="top">
            <section>
                <h4>Empresa</h4>
                <p>Sobre</p>
                <p>Empregos</p>
                <p>For the Record</p>
            </section>
    
            <section>
                <h4>Comunidades</h4>
                <a href=""><p>Para Artistas</p></a>
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
                <h4>Planos do Spotify</h4>
                <p>Premium Individual</p>
                <p>Premium Duo</p>
                <p>Premium Família</p>
                <p>Premium Universitário</p>
                <p>Spotify Free</p>
            </section>
            
            <section class="redes">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                    </svg>
                </button>

                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/>
                    </svg>
                </button>
                
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                    </svg>
                </button>
                
            </section>
        </section>

        <section class="bottom">
            <article>
                <p>Legal</p>
                <p>Segurança e Centro de privacidade</p>
                <p>Política de privacidade</p>
                <p>Cookies</p>
                <p>Sobre anúncios</p>
                <p>Acessibilidade</p>
            </article>
            
            <article class="direitos">
                <p>© 2025 Giana Station AB</p>
            </article>
        </section>
    </footer>

</body>
</html>