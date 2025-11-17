<?php
// Conectar BD
function conectarBD() {
    $conexao = mysqli_connect('localhost', 'root', '', 'gianastation');

    if (!$conexao) {
        die("Erro na conexão: " . mysqli_connect_error());
    }

    mysqli_set_charset($conexao, "utf8mb4");

    return $conexao;
}

function fecharConexao($conexao) {
    if ($conexao) {
        mysqli_close($conexao);
    }
}

function limparDados($dados) {
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados, ENT_QUOTES, 'UTF-8');
    return $dados;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function criptografarSenha($senha) {
    return password_hash($senha, PASSWORD_DEFAULT);
}

// Cadastrar usuário
function inserirUsuario($nome, $email, $senha, $data_nascimento, $genero) {
    $conexao = conectarBD();

    $senha_hash = criptografarSenha($senha);

    $sql = "INSERT INTO usuarios (Nome, Email, Senha, Data_nascimento, Genero)
            VALUES ('$nome', '$email', '$senha_hash', '$data_nascimento', '$genero')";
    
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado) {
        $user_id = mysqli_insert_id($conexao);
        fecharConexao($conexao);
        return $user_id;
    } else {
        fecharConexao($conexao);
        return false;
    }
}

// Localizar usuario - email
function buscarUsuarioEmail($email) {
    $conexao = conectarBD();

    $sql = "SELECT * FROM usuarios WHERE Email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $usuario;
    } else {
        fecharConexao($conexao);
        return null;
    }   
}

// Localizar usuario - ID
function buscarUsuarioID($id) {
    $conexao = conectarBD();

    $sql = "SELECT * FROM usuarios WHERE ID_Usuario = '$id'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $usuario;
    } else {
        fecharConexao($conexao);
        return null;
    }   
}

// Atualizar dados usuário
function atualizarUsuario($id, $nome, $foto_perfil = null) {
    $conexao = conectarBD();
    
    if ($foto_perfil != null) {
        $sql = "UPDATE usuarios 
        SET Nome = '$nome', Foto_perfil = '$foto_perfil' 
        WHERE ID_Usuario = $id";
    } else {
        $sql = "UPDATE usuarios 
        SET Nome = '$nome' 
        WHERE ID_Usuario = $id";
    }
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Cadastrar artista 
function inserirArtista($fk_usuario, $nome_artistico, $capa_path, $genero_art, $biografia, $instagram, $twitter, $tiktok, $site) {
    $conexao = conectarBD();
    
    $sql = "INSERT INTO artistas (FK_Usuario, Nome_artistico, Capa_path, Genero_art, Biografia, Instagram, Twitter, Tiktok, Site) 
            VALUES ($fk_usuario, '$nome_artistico', '$capa_path', '$genero_art', '$biografia', '$instagram', '$twitter', '$tiktok', '$site')";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $artista_id = mysqli_insert_id($conexao);
        fecharConexao($conexao);
        return $artista_id;
    } else {
        fecharConexao($conexao);
        return false;
    }
}

function verificarNomeArtisticoExiste($nome_artistico) {
    $conexao = conectarBD();
    
    $sql = "SELECT ID_Artista FROM artistas WHERE Nome_artistico = '$nome_artistico'";
    $resultado = mysqli_query($conexao, $sql);
    
    $existe = mysqli_num_rows($resultado) > 0;
    
    fecharConexao($conexao);
    return $existe;
}

// Buscar artista - id usuario
function buscarArtistaPorUsuario($user_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM artistas WHERE FK_Usuario = $user_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $artista = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $artista;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Buscar artista - id
function buscarArtistaPorId($id) {
        $conexao = conectarBD();
    
    $sql = "SELECT a.*, u.Nome, u.Email 
            FROM artistas a 
            INNER JOIN usuarios u ON a.FK_Usuario = u.ID_Usuario 
            WHERE a.ID_Artista = $id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $artista = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $artista;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Listar artistas
function listarTodosArtistas() {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM artistas ORDER BY Nome_artistico ASC";
    $resultado = mysqli_query($conexao, $sql);
    $artistas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $artistas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $artistas;
}

// Atualizar dados do artista
function atualizarArtista($id, $nome_artistico, $biografia, $genero_art, $instagram, $twitter, $tiktok, $site, $foto_perfil = null, $capa_path = null) {
    $conexao = conectarBD();
    
    $nome_artistico = mysqli_real_escape_string($conexao, $nome_artistico);
    $biografia = mysqli_real_escape_string($conexao, $biografia);
    $genero_art = mysqli_real_escape_string($conexao, $genero_art);
    $instagram = mysqli_real_escape_string($conexao, $instagram);
    $twitter = mysqli_real_escape_string($conexao, $twitter);
    $tiktok = mysqli_real_escape_string($conexao, $tiktok);
    $site = mysqli_real_escape_string($conexao, $site);
    
    $sql = "UPDATE artistas SET 
            Nome_artistico = '$nome_artistico',
            Biografia = '$biografia',
            Genero_art = '$genero_art',
            Instagram = '$instagram',
            Twitter = '$twitter',
            Tiktok = '$tiktok',
            Site = '$site'";
    
    if ($foto_perfil != null) {
        $foto_perfil = mysqli_real_escape_string($conexao, $foto_perfil);
        $sql .= ", Foto_perfil = '$foto_perfil'";
    }
    
    if ($capa_path != null) {
        $capa_path = mysqli_real_escape_string($conexao, $capa_path);
        $sql .= ", Capa_path = '$capa_path'";
    }
    
    $sql .= ", Data_atualizacao = CURRENT_TIMESTAMP WHERE ID_Artista = $id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Cadastrar música
function inserirMusica($fk_artista, $titulo, $artista, $album, $tipo, $genero_mus, $ano, $duracao, $letra, $audio_path, $capa_mus_path) {
    $conexao = conectarBD();
    
    $sql = "INSERT INTO musicas (FK_Artista, Titulo, Artista, Album, Tipo, Genero_mus, Ano, Duracao, Letra, Audio_path, Capa_mus_path) 
            VALUES ($fk_artista, '$titulo', '$artista', '$album', '$tipo', '$genero_mus', $ano, '$duracao', '$letra', '$audio_path', '$capa_mus_path')";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $musica_id = mysqli_insert_id($conexao);
        fecharConexao($conexao);
        return $musica_id;
    } else {
        fecharConexao($conexao);
        return false;
    }
}

// Listar todas as músicas
function listarMusicasArtista($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM musicas WHERE FK_Artista = $artista_id ORDER BY Ano DESC, Titulo ASC";
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar música - id
function buscarMusicaPorId($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM musicas WHERE ID_Musica = $id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $musica = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $musica;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

function verificarMusicaExiste($titulo, $artista, $album) {
    $conexao = conectarBD();
    
    $sql = "SELECT ID_Musica FROM musicas WHERE Titulo = '$titulo' AND Artista = '$artista' AND Album = '$album'";
    $resultado = mysqli_query($conexao, $sql);
    
    $existe = mysqli_num_rows($resultado) > 0;
    
    fecharConexao($conexao);
    return $existe;
}

// Buscar discografia - artista
function buscarDiscografiaAgrupada($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT DISTINCT Album, Tipo, Ano, MAX(Capa_mus_path) as Capa, COUNT(*) as Total_faixas 
            FROM musicas 
            WHERE FK_Artista = $artista_id 
            GROUP BY Album, Tipo, Ano 
            ORDER BY Ano DESC";
    
    $resultado = mysqli_query($conexao, $sql);
    $albums = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $albums[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $albums;
}

// Total de música - artista
function contarMusicasArtista($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT COUNT(*) as total FROM musicas WHERE FK_Artista = $artista_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);
        $total = $row['total'];
        fecharConexao($conexao);
        return $total;
    } else {
        fecharConexao($conexao);
        return 0;
    }
}

// Listar música - álbum
function listarMusicasPorAlbum($artista_id, $album) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM musicas WHERE FK_Artista = $artista_id AND Album = '$album' ORDER BY Titulo ASC";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Deletar música
function deletarMusica($id, $artista_id) {
    $conexao = conectarBD();
    
    $sql = "DELETE FROM musicas WHERE ID_Musica = $id AND FK_Artista = $artista_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Criar playlist
function criarPlaylist($fk_usuario, $nome_playlist, $capa_play_path = null) {
    $conexao = conectarBD();
    
    // Escapar dados para prevenir SQL injection
    $nome_playlist = mysqli_real_escape_string($conexao, $nome_playlist);
    
    if ($capa_play_path != null) {
        $capa_play_path = mysqli_real_escape_string($conexao, $capa_play_path);
        $sql = "INSERT INTO playlists (FK_Usuario, Nome_playlist, Capa_play_path) 
                VALUES ($fk_usuario, '$nome_playlist', '$capa_play_path')";
    } else {
        $sql = "INSERT INTO playlists (FK_Usuario, Nome_playlist) 
                VALUES ($fk_usuario, '$nome_playlist')";
    }
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $playlist_id = mysqli_insert_id($conexao);
        fecharConexao($conexao);
        return $playlist_id;
    } else {
        // Log do erro para debug
        error_log("Erro ao criar playlist: " . mysqli_error($conexao));
        fecharConexao($conexao);
        return false;
    }
}

// Verificar se playlist com mesmo nome já existe para o usuário
function verificarPlaylistExiste($user_id, $nome_playlist) {
    $conexao = conectarBD();
    
    $nome_playlist = mysqli_real_escape_string($conexao, $nome_playlist);
    
    $sql = "SELECT ID_Playlist FROM playlists 
            WHERE FK_Usuario = $user_id AND Nome_playlist = '$nome_playlist'";
    
    $resultado = mysqli_query($conexao, $sql);
    $existe = mysqli_num_rows($resultado) > 0;
    
    fecharConexao($conexao);
    return $existe;
}

// Listar playlist por usuário
function listarPlaylistsUsuario($user_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM playlists WHERE FK_Usuario = $user_id ORDER BY Nome_playlist ASC";
    
    $resultado = mysqli_query($conexao, $sql);
    $playlists = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $playlists[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $playlists;
}

// Buscar playlist por ID
function buscarPlaylistPorId($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM playlists WHERE ID_Playlist = $id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $playlist = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $playlist;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Deletar playlist 
function deletarPlaylist($id, $user_id) {
    $conexao = conectarBD();
    
    $sql = "DELETE FROM playlists WHERE ID_Playlist = $id AND FK_Usuario = $user_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

function listarTodasMusicas($limit = null) {
    $conexao = conectarBD();
    
    $sql = "SELECT m.*, a.Nome_artistico, a.Capa_path as Foto_artista 
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            ORDER BY m.Ano DESC, m.Titulo ASC";
    
    if ($limit !== null) {
        $sql .= " LIMIT $limit";
    }
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar música com detalhes completos
function buscarMusicaCompleta($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT m.*, a.Nome_artistico, a.ID_Artista, a.Capa_path as Foto_artista, 
            a.Genero_art, a.Instagram, a.Twitter, a.Tiktok, a.Site
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            WHERE m.ID_Musica = $id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $musica = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $musica;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Buscar músicas relacionadas (mesmo gênero ou artista)
function buscarMusicasRelacionadas($musica_id, $artista_id, $genero, $limit = 4) {
    $conexao = conectarBD();
    
    $genero = mysqli_real_escape_string($conexao, $genero);
    
    $sql = "SELECT m.*, a.Nome_artistico, a.Capa_path as Foto_artista 
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            WHERE m.ID_Musica != $musica_id 
            AND (m.FK_Artista = $artista_id OR m.Genero_mus = '$genero')
            ORDER BY RAND() 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar artista completo com estatísticas
function buscarArtistaCompleto($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT a.*, u.Nome, u.Email 
            FROM artistas a 
            INNER JOIN usuarios u ON a.FK_Usuario = u.ID_Usuario 
            WHERE a.ID_Artista = $id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $artista = mysqli_fetch_assoc($resultado);
        
        // Contar total de músicas
        $sql_musicas = "SELECT COUNT(*) as total FROM musicas WHERE FK_Artista = $id";
        $resultado_musicas = mysqli_query($conexao, $sql_musicas);
        $row_musicas = mysqli_fetch_assoc($resultado_musicas);
        $artista['total_musicas'] = $row_musicas['total'];
        
        // Contar total de álbuns
        $sql_albums = "SELECT COUNT(DISTINCT Album) as total FROM musicas WHERE FK_Artista = $id";
        $resultado_albums = mysqli_query($conexao, $sql_albums);
        $row_albums = mysqli_fetch_assoc($resultado_albums);
        $artista['total_albums'] = $row_albums['total'];
        
        fecharConexao($conexao);
        return $artista;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Buscar músicas populares do artista
function buscarMusicasPopularesArtista($artista_id, $limit = 5) {
    $conexao = conectarBD();
    
    $sql = "SELECT m.*, a.Nome_artistico 
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            WHERE m.FK_Artista = $artista_id 
            ORDER BY m.Ano DESC, m.Titulo ASC 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar discografia do artista
function buscarDiscografiaArtista($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT DISTINCT Album, Tipo, Ano, 
            (SELECT Capa_mus_path FROM musicas WHERE FK_Artista = $artista_id AND Album = m.Album LIMIT 1) as Capa,
            (SELECT COUNT(*) FROM musicas WHERE FK_Artista = $artista_id AND Album = m.Album) as Total_faixas
            FROM musicas m 
            WHERE FK_Artista = $artista_id 
            GROUP BY Album, Tipo, Ano 
            ORDER BY Ano DESC";
    
    $resultado = mysqli_query($conexao, $sql);
    $albums = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $albums[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $albums;
}

// Buscar playlist com detalhes
function buscarPlaylistCompleta($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT p.*, u.Nome as Nome_usuario 
            FROM playlists p 
            INNER JOIN usuarios u ON p.FK_Usuario = u.ID_Usuario 
            WHERE p.ID_Playlist = $id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $playlist = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $playlist;
    } else {
        fecharConexao($conexao);
        return null;
    }
}

// Contar músicas na playlist
function contarMusicasPlaylist($playlist_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT COUNT(*) as total FROM playlist_musicas WHERE FK_Playlist = $playlist_id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);
        $total = $row['total'];
        fecharConexao($conexao);
        return $total;
    }
    
    fecharConexao($conexao);
    return 0;
}

// Buscar artistas mais ouvidos (simulado - retorna artistas aleatórios)
function buscarArtistasPopulares($limit = 4) {
    $conexao = conectarBD();
    
    $sql = "SELECT a.ID_Artista, a.Nome_artistico, a.Capa_path, a.Genero_art,
            (SELECT COUNT(*) FROM musicas WHERE FK_Artista = a.ID_Artista) as Total_musicas
            FROM artistas a 
            WHERE a.Capa_path IS NOT NULL AND a.Capa_path != ''
            ORDER BY RAND() 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $artistas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $artistas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $artistas;
}

// Buscar músicas recentes
function buscarMusicasRecentes($limit = 8) {
    $conexao = conectarBD();
    
    $sql = "SELECT m.*, a.Nome_artistico, a.Capa_path as Foto_artista 
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            ORDER BY m.Ano DESC, m.ID_Musica DESC 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar álbum completo
function buscarAlbumCompleto($artista_id, $album_nome) {
    $conexao = conectarBD();
    
    $album_nome = mysqli_real_escape_string($conexao, $album_nome);
    
    $sql = "SELECT m.*, a.Nome_artistico, a.ID_Artista, a.Capa_path as Foto_artista
            FROM musicas m 
            INNER JOIN artistas a ON m.FK_Artista = a.ID_Artista 
            WHERE m.FK_Artista = $artista_id AND m.Album = '$album_nome'
            ORDER BY m.Titulo ASC";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Calcular duração total do álbum
function calcularDuracaoTotal($musicas) {
    $total_segundos = 0;
    
    foreach ($musicas as $musica) {
        if (!empty($musica['Duracao'])) {
            list($min, $sec) = explode(':', $musica['Duracao']);
            $total_segundos += ($min * 60) + $sec;
        }
    }
    
    $horas = floor($total_segundos / 3600);
    $minutos = floor(($total_segundos % 3600) / 60);
    
    if ($horas > 0) {
        return $horas . 'h ' . $minutos . 'min';
    } else {
        return $minutos . ' min';
    }
}

// Validar login 
function validarLogin($email, $senha) {
    $conexao = conectarBD();
    
    $email = mysqli_real_escape_string($conexao, $email);
    $senha = mysqli_real_escape_string($conexao, $senha);
    
    // Buscar usuário no banco
    $sql = "SELECT * FROM usuarios WHERE Email = '$email'";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        // Verificar senha
        if ($senha === $usuario['Senha']) {
            fecharConexao($conexao);
            return $usuario;
        }
    }
    
    fecharConexao($conexao);
    return false;
}

// Atualizar senha do usuário 
function atualizarSenhaUsuario($id, $nova_senha) {
    $conexao = conectarBD();
    
    $nova_senha = mysqli_real_escape_string($conexao, $nova_senha);
    
    $sql = "UPDATE usuarios SET Senha = '$nova_senha' WHERE ID_Usuario = $id";
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}
// Buscar estatísticas do artista
function buscarEstatisticasArtista($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM estatisticas_artista WHERE FK_Artista = $artista_id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $stats = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $stats;
    }
    
    fecharConexao($conexao);
    return null;
}

// Buscar performance do artista (7 dias ou 28 dias)
function buscarPerformanceArtista($artista_id, $periodo = '7_dias') {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM performance_artista 
            WHERE FK_Artista = $artista_id AND Periodo = '$periodo' 
            ORDER BY Data_registro DESC 
            LIMIT 1";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $performance = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $performance;
    }
    
    fecharConexao($conexao);
    return null;
}

// Buscar lançamentos recentes do artista
function buscarLancamentosRecentes($artista_id, $limit = 3) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM lancamentos 
            WHERE FK_Artista = $artista_id 
            ORDER BY Ano DESC, Data_lancamento DESC 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $lancamentos = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $lancamentos[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $lancamentos;
}

// Buscar todos os lançamentos do artista
function buscarTodosLancamentos($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM lancamentos 
            WHERE FK_Artista = $artista_id 
            ORDER BY Ano DESC, Data_lancamento DESC";
    
    $resultado = mysqli_query($conexao, $sql);
    $lancamentos = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $lancamentos[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $lancamentos;
}

// Buscar lançamentos por tipo
function buscarLancamentosPorTipo($artista_id, $tipo) {
    $conexao = conectarBD();
    
    $tipo = mysqli_real_escape_string($conexao, $tipo);
    
    $sql = "SELECT * FROM lancamentos 
            WHERE FK_Artista = $artista_id AND Tipo = '$tipo'
            ORDER BY Ano DESC, Data_lancamento DESC";
    
    $resultado = mysqli_query($conexao, $sql);
    $lancamentos = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $lancamentos[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $lancamentos;
}

// Buscar lançamento por ID
function buscarLancamentoPorId($lancamento_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM lancamentos WHERE ID_Lancamento = $lancamento_id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $lancamento = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $lancamento;
    }
    
    fecharConexao($conexao);
    return null;
}

// Buscar faixas de um lançamento
function buscarFaixasLancamento($lancamento_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT fl.*, m.Titulo, m.Duracao, m.Capa_mus_path 
            FROM faixas_lancamento fl
            INNER JOIN musicas m ON fl.FK_Musica = m.ID_Musica
            WHERE fl.FK_Lancamento = $lancamento_id
            ORDER BY fl.Numero_faixa ASC";
    
    $resultado = mysqli_query($conexao, $sql);
    $faixas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $faixas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $faixas;
}

// Contar lançamentos por tipo
function contarLancamentosPorTipo($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT 
                SUM(CASE WHEN Tipo = 'Single' THEN 1 ELSE 0 END) as singles,
                SUM(CASE WHEN Tipo = 'EP' THEN 1 ELSE 0 END) as eps,
                SUM(CASE WHEN Tipo = 'Álbum' THEN 1 ELSE 0 END) as albums
            FROM lancamentos 
            WHERE FK_Artista = $artista_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $contagem = mysqli_fetch_assoc($resultado);
        fecharConexao($conexao);
        return $contagem;
    }
    
    fecharConexao($conexao);
    return ['singles' => 0, 'eps' => 0, 'albums' => 0];
}

// Buscar top músicas do artista
function buscarTopMusicasArtista($artista_id, $limit = 5) {
    $conexao = conectarBD();
    
    $sql = "SELECT t.*, m.Titulo, m.Album, m.Ano, m.Capa_mus_path
            FROM top_musicas_artista t
            INNER JOIN musicas m ON t.FK_Musica = m.ID_Musica
            WHERE t.FK_Artista = $artista_id
            ORDER BY t.Posicao ASC
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $musicas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $musicas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $musicas;
}

// Buscar demografia por país
function buscarDemografiaPais($artista_id, $limit = 5) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM demografia_pais 
            WHERE FK_Artista = $artista_id 
            ORDER BY Ranking ASC 
            LIMIT $limit";
    
    $resultado = mysqli_query($conexao, $sql);
    $paises = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $paises[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $paises;
}

// Buscar demografia por idade
function buscarDemografiaIdade($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM demografia_idade 
            WHERE FK_Artista = $artista_id 
            ORDER BY 
                CASE Faixa_etaria
                    WHEN '18-24' THEN 1
                    WHEN '25-34' THEN 2
                    WHEN '35+' THEN 3
                    ELSE 4
                END";
    
    $resultado = mysqli_query($conexao, $sql);
    $faixas = array();
    
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $faixas[] = $row;
        }
    }
    
    fecharConexao($conexao);
    return $faixas;
}

// Inserir lançamento
function inserirLancamento($artista_id, $titulo, $tipo, $ano, $capa_path, $gravadora, $descricao, $total_faixas, $data_lancamento) {
    $conexao = conectarBD();
    
    $titulo = mysqli_real_escape_string($conexao, $titulo);
    $tipo = mysqli_real_escape_string($conexao, $tipo);
    $gravadora = mysqli_real_escape_string($conexao, $gravadora);
    $descricao = mysqli_real_escape_string($conexao, $descricao);
    $capa_path = mysqli_real_escape_string($conexao, $capa_path);
    
    $sql = "INSERT INTO lancamentos 
            (FK_Artista, Titulo, Tipo, Ano, Capa_path, Gravadora, Descricao, Total_faixas, Data_lancamento) 
            VALUES 
            ($artista_id, '$titulo', '$tipo', $ano, '$capa_path', '$gravadora', '$descricao', $total_faixas, '$data_lancamento')";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $lancamento_id = mysqli_insert_id($conexao);
        
        // Atualizar total de lançamentos nas estatísticas
        $sql_update = "UPDATE estatisticas_artista 
                       SET Total_lancamentos = (SELECT COUNT(*) FROM lancamentos WHERE FK_Artista = $artista_id)
                       WHERE FK_Artista = $artista_id";
        mysqli_query($conexao, $sql_update);
        
        fecharConexao($conexao);
        return $lancamento_id;
    }
    
    fecharConexao($conexao);
    return false;
}

// Atualizar lançamento
function atualizarLancamento($lancamento_id, $titulo, $tipo, $ano, $gravadora, $descricao, $capa_path = null) {
    $conexao = conectarBD();
    
    $titulo = mysqli_real_escape_string($conexao, $titulo);
    $tipo = mysqli_real_escape_string($conexao, $tipo);
    $gravadora = mysqli_real_escape_string($conexao, $gravadora);
    $descricao = mysqli_real_escape_string($conexao, $descricao);
    
    $sql = "UPDATE lancamentos SET 
            Titulo = '$titulo',
            Tipo = '$tipo',
            Ano = $ano,
            Gravadora = '$gravadora',
            Descricao = '$descricao'";
    
    if ($capa_path != null) {
        $capa_path = mysqli_real_escape_string($conexao, $capa_path);
        $sql .= ", Capa_path = '$capa_path'";
    }
    
    $sql .= " WHERE ID_Lancamento = $lancamento_id";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Deletar lançamento
function deletarLancamento($lancamento_id, $artista_id) {
    $conexao = conectarBD();
    
    $sql = "DELETE FROM lancamentos WHERE ID_Lancamento = $lancamento_id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        // Atualizar total de lançamentos nas estatísticas
        $sql_update = "UPDATE estatisticas_artista 
                       SET Total_lancamentos = (SELECT COUNT(*) FROM lancamentos WHERE FK_Artista = $artista_id)
                       WHERE FK_Artista = $artista_id";
        mysqli_query($conexao, $sql_update);
    }
    
    fecharConexao($conexao);
    return $resultado;
}

// Adicionar faixa ao lançamento
function adicionarFaixaLancamento($lancamento_id, $musica_id, $numero_faixa, $destaque = false) {
    $conexao = conectarBD();
    
    $destaque_value = $destaque ? 1 : 0;
    
    $sql = "INSERT INTO faixas_lancamento 
            (FK_Lancamento, FK_Musica, Numero_faixa, Destaque) 
            VALUES 
            ($lancamento_id, $musica_id, $numero_faixa, $destaque_value)";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        // Atualizar contagem de faixas no lançamento
        $sql_update = "UPDATE lancamentos 
                       SET Total_faixas = (SELECT COUNT(*) FROM faixas_lancamento WHERE FK_Lancamento = $lancamento_id)
                       WHERE ID_Lancamento = $lancamento_id";
        mysqli_query($conexao, $sql_update);
    }
    
    fecharConexao($conexao);
    return $resultado;
}

// Remover faixa do lançamento
function removerFaixaLancamento($faixa_id) {
    $conexao = conectarBD();
    
    // Buscar ID do lançamento antes de deletar
    $sql_get = "SELECT FK_Lancamento FROM faixas_lancamento WHERE ID_Faixa = $faixa_id";
    $resultado_get = mysqli_query($conexao, $sql_get);
    
    if ($resultado_get && mysqli_num_rows($resultado_get) > 0) {
        $row = mysqli_fetch_assoc($resultado_get);
        $lancamento_id = $row['FK_Lancamento'];
        
        // Deletar faixa
        $sql = "DELETE FROM faixas_lancamento WHERE ID_Faixa = $faixa_id";
        $resultado = mysqli_query($conexao, $sql);
        
        if ($resultado) {
            // Atualizar contagem de faixas no lançamento
            $sql_update = "UPDATE lancamentos 
                           SET Total_faixas = (SELECT COUNT(*) FROM faixas_lancamento WHERE FK_Lancamento = $lancamento_id)
                           WHERE ID_Lancamento = $lancamento_id";
            mysqli_query($conexao, $sql_update);
        }
        
        fecharConexao($conexao);
        return $resultado;
    }
    
    fecharConexao($conexao);
    return false;
}

// Formatar número para exibição
function formatarNumero($numero) {
    if ($numero >= 1000000) {
        return number_format($numero / 1000000, 1, ',', '.') . 'M';
    } elseif ($numero >= 1000) {
        return number_format($numero / 1000, 1, ',', '.') . 'K';
    }
    return number_format($numero, 0, ',', '.');
}

// Formatar percentual
function formatarPercentual($percentual) {
    return ($percentual >= 0 ? '+' : '') . number_format($percentual, 1, ',', '.') . '%';
}

// Atualizar estatísticas do artista manualmente
function atualizarEstatisticasArtista($artista_id, $data) {
    $conexao = conectarBD();
    
    $total_streams = isset($data['Total_streams']) ? intval($data['Total_streams']) : 0;
    $ouvintes_mensais = isset($data['Ouvintes_mensais']) ? intval($data['Ouvintes_mensais']) : 0;
    $total_lancamentos = isset($data['Total_lancamentos']) ? intval($data['Total_lancamentos']) : 0;
    $total_seguidores = isset($data['Total_seguidores']) ? intval($data['Total_seguidores']) : 0;
    $crescimento_streams = isset($data['Crescimento_streams_percentual']) ? floatval($data['Crescimento_streams_percentual']) : 0;
    $crescimento_ouvintes = isset($data['Crescimento_ouvintes_percentual']) ? floatval($data['Crescimento_ouvintes_percentual']) : 0;
    $crescimento_seguidores = isset($data['Crescimento_seguidores']) ? intval($data['Crescimento_seguidores']) : 0;
    
    $sql = "INSERT INTO estatisticas_artista 
            (FK_Artista, Total_streams, Ouvintes_mensais, Total_lancamentos, Total_seguidores, 
             Crescimento_streams_percentual, Crescimento_ouvintes_percentual, Crescimento_seguidores)
            VALUES 
            ($artista_id, $total_streams, $ouvintes_mensais, $total_lancamentos, $total_seguidores,
             $crescimento_streams, $crescimento_ouvintes, $crescimento_seguidores)
            ON DUPLICATE KEY UPDATE
                Total_streams = $total_streams,
                Ouvintes_mensais = $ouvintes_mensais,
                Total_lancamentos = $total_lancamentos,
                Total_seguidores = $total_seguidores,
                Crescimento_streams_percentual = $crescimento_streams,
                Crescimento_ouvintes_percentual = $crescimento_ouvintes,
                Crescimento_seguidores = $crescimento_seguidores,
                Data_atualizacao = CURRENT_TIMESTAMP";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Inserir performance do artista
function inserirPerformanceArtista($artista_id, $periodo, $total_streams, $crescimento_percentual, $data_inicio, $data_fim) {
    $conexao = conectarBD();
    
    $periodo = mysqli_real_escape_string($conexao, $periodo);
    
    $sql = "INSERT INTO performance_artista 
            (FK_Artista, Periodo, Total_streams, Crescimento_percentual, Data_inicio, Data_fim)
            VALUES 
            ($artista_id, '$periodo', $total_streams, $crescimento_percentual, '$data_inicio', '$data_fim')";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Inserir ou atualizar top música
function inserirTopMusica($artista_id, $musica_id, $posicao, $total_streams, $crescimento_percentual) {
    $conexao = conectarBD();
    
    $sql = "INSERT INTO top_musicas_artista 
            (FK_Artista, FK_Musica, Posicao, Total_streams, Crescimento_percentual)
            VALUES 
            ($artista_id, $musica_id, $posicao, $total_streams, $crescimento_percentual)
            ON DUPLICATE KEY UPDATE
                FK_Musica = $musica_id,
                Total_streams = $total_streams,
                Crescimento_percentual = $crescimento_percentual,
                Data_atualizacao = CURRENT_TIMESTAMP";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Inserir ou atualizar demografia por país
function inserirDemografiaPais($artista_id, $pais, $codigo_pais, $emoji_bandeira, $total_ouvintes, $percentual, $ranking) {
    $conexao = conectarBD();
    
    $pais = mysqli_real_escape_string($conexao, $pais);
    $codigo_pais = mysqli_real_escape_string($conexao, $codigo_pais);
    $emoji_bandeira = mysqli_real_escape_string($conexao, $emoji_bandeira);
    
    $sql = "INSERT INTO demografia_pais 
            (FK_Artista, Pais, Codigo_pais, Emoji_bandeira, Total_ouvintes, Percentual, Ranking)
            VALUES 
            ($artista_id, '$pais', '$codigo_pais', '$emoji_bandeira', $total_ouvintes, $percentual, $ranking)
            ON DUPLICATE KEY UPDATE
                Total_ouvintes = $total_ouvintes,
                Percentual = $percentual,
                Ranking = $ranking,
                Data_atualizacao = CURRENT_TIMESTAMP";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Inserir ou atualizar demografia por idade
function inserirDemografiaIdade($artista_id, $faixa_etaria, $total_ouvintes, $percentual) {
    $conexao = conectarBD();
    
    $faixa_etaria = mysqli_real_escape_string($conexao, $faixa_etaria);
    
    $sql = "INSERT INTO demografia_idade 
            (FK_Artista, Faixa_etaria, Total_ouvintes, Percentual)
            VALUES 
            ($artista_id, '$faixa_etaria', $total_ouvintes, $percentual)
            ON DUPLICATE KEY UPDATE
                Total_ouvintes = $total_ouvintes,
                Percentual = $percentual,
                Data_atualizacao = CURRENT_TIMESTAMP";
    
    $resultado = mysqli_query($conexao, $sql);
    
    fecharConexao($conexao);
    return $resultado;
}

// Verificar se artista tem estatísticas
function artistaTemEstatisticas($artista_id) {
    $conexao = conectarBD();
    
    $sql = "SELECT COUNT(*) as total FROM estatisticas_artista WHERE FK_Artista = $artista_id";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);
        $tem_stats = $row['total'] > 0;
        fecharConexao($conexao);
        return $tem_stats;
    }
    
    fecharConexao($conexao);
    return false;
}

// Calcular estatísticas de audiência
function calcularEstatisticasAudiencia($artista_id) {
    $conexao = conectarBD();
    
    // Total de streams das músicas
    $sql_streams = "SELECT COALESCE(SUM(sm.Quantidade_streams), 0) as total
                    FROM streams_musica sm
                    INNER JOIN musicas m ON sm.FK_Musica = m.ID_Musica
                    WHERE m.FK_Artista = $artista_id";
    $resultado_streams = mysqli_query($conexao, $sql_streams);
    $total_streams = 0;
    if ($resultado_streams) {
        $row = mysqli_fetch_assoc($resultado_streams);
        $total_streams = $row['total'];
    }
    
    // Total de seguidores
    $sql_seguidores = "SELECT COUNT(*) as total FROM seguidores WHERE FK_Artista = $artista_id";
    $resultado_seguidores = mysqli_query($conexao, $sql_seguidores);
    $total_seguidores = 0;
    if ($resultado_seguidores) {
        $row = mysqli_fetch_assoc($resultado_seguidores);
        $total_seguidores = $row['total'];
    }
    
    // Total de lançamentos
    $sql_lancamentos = "SELECT COUNT(*) as total FROM lancamentos WHERE FK_Artista = $artista_id";
    $resultado_lancamentos = mysqli_query($conexao, $sql_lancamentos);
    $total_lancamentos = 0;
    if ($resultado_lancamentos) {
        $row = mysqli_fetch_assoc($resultado_lancamentos);
        $total_lancamentos = $row['total'];
    }
    
    fecharConexao($conexao);
    
    return [
        'Total_streams' => $total_streams,
        'Total_seguidores' => $total_seguidores,
        'Total_lancamentos' => $total_lancamentos
    ];
}
?>