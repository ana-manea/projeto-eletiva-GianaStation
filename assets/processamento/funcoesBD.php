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
    
    $sql = "UPDATE artistas SET 
            Nome_artistico = '$nome_artistico',
            Biografia = '$biografia',
            Genero_art = '$genero_art',
            Instagram = '$instagram',
            Twitter = '$twitter',
            Tiktok = '$tiktok',
            Site = '$site'";
    
    if ($foto_perfil != null) {
        $sql .= ", Foto_perfil = '$foto_perfil'";
    }
    
    if ($capa_path != null) {
        $sql .= ", Capa_path = '$capa_path'";
    }
    
    $sql .= " WHERE ID_Artista = $id";
    
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

?>