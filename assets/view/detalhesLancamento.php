<?php
require_once 'config.php';

// Receber ID do álbum
$albumId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dados de exemplo 
$discografia = [
    1 => [
        'id' => 1,
        'titulo' => 'Trevo',
        'ano' => 2017,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
        'tipo' => 'Álbum',
        'gravadora' => 'Universal Music',
        'descricao' => 'Álbum de estreia da dupla com grandes sucessos.',
        'musicas' => [
            ['id' => 1, 'numero' => 1, 'titulo' => 'Trevo (Tu)', 'duracao' => '3:45', 'streams' => '450K', 'destaque' => true],
            ['id' => 2, 'numero' => 2, 'titulo' => 'Não Sinto Nada', 'duracao' => '3:28', 'streams' => '320K', 'destaque' => false],
            ['id' => 3, 'numero' => 3, 'titulo' => 'Fico', 'duracao' => '3:15', 'streams' => '280K', 'destaque' => false],
            ['id' => 4, 'numero' => 4, 'titulo' => 'Lisboa-Madrid', 'duracao' => '3:52', 'streams' => '245K', 'destaque' => false],
        ]
    ],
    2 => [
        'id' => 2,
        'titulo' => 'O Tempo É Agora',
        'ano' => 2018,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b2735d7cf1a8508aa994d4bde5c8',
        'tipo' => 'Álbum',
        'gravadora' => 'Universal Music',
        'descricao' => 'Segundo álbum de estúdio com 12 faixas inéditas.',
        'musicas' => [
            ['id' => 5, 'numero' => 1, 'titulo' => 'Tempo', 'duracao' => '3:52', 'streams' => '280K', 'destaque' => true],
            ['id' => 6, 'numero' => 2, 'titulo' => 'Agora', 'duracao' => '4:02', 'streams' => '245K', 'destaque' => false],
            ['id' => 7, 'numero' => 3, 'titulo' => 'Mesma Direção', 'duracao' => '3:38', 'streams' => '198K', 'destaque' => false],
        ]
    ],
    3 => [
        'id' => 3,
        'titulo' => 'Esquinas',
        'ano' => 2024,
        'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
        'tipo' => 'Álbum',
        'gravadora' => 'Universal Music',
        'descricao' => 'O terceiro álbum de estúdio da dupla traz 12 faixas inéditas que exploram novas sonoridades mantendo a essência da MPB.',
        'musicas' => [
            ['id' => 8, 'numero' => 1, 'titulo' => 'Esquinas', 'duracao' => '3:45', 'streams' => '450K', 'destaque' => true],
            ['id' => 9, 'numero' => 2, 'titulo' => 'Singular', 'duracao' => '4:02', 'streams' => '320K', 'destaque' => false],
            ['id' => 10, 'numero' => 3, 'titulo' => 'Seu Olhar', 'duracao' => '3:28', 'streams' => '280K', 'destaque' => false],
            ['id' => 11, 'numero' => 4, 'titulo' => 'Deixa Estar', 'duracao' => '3:55', 'streams' => '245K', 'destaque' => false],
        ]
    ]
];

// Verificar se o álbum existe
if (!isset($discografia[$albumId])) {
    header("Location: dashboardArtDiscografia.php?lang=" . $currentLang);
    exit;
}

$lancamento = $discografia[$albumId];

$totalDuracao = 0;
foreach ($lancamento['musicas'] as $musica) {
    list($min, $sec) = explode(':', $musica['duracao']);
    $totalDuracao += ($min * 60) + $sec;
}
$totalMin = floor($totalDuracao / 60);

$pageTitle = $lancamento['titulo'];
$lancamentoJson = json_encode($lancamento);
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
                <a href="dashboardArtista.php" class="artist-profile">
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
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                        <button class="btn-primary" onclick="editAlbum()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            <span><?php echo translateText('Editar Álbum'); ?></span>
                        </button>
                        <button class="btn-secondary" onclick="openAddMusicModal()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
            
            <div class="tracks-list" id="tracksList">
                <?php foreach ($lancamento['musicas'] as $musica): ?>
                    <div class="track-item" data-id="<?php echo $musica['id']; ?>">
                        <div class="track-col-number">
                            <span><?php echo $musica['numero']; ?></span>
                        </div>
                        
                        <div class="track-col-title">
                            <span class="track-title"><?php echo htmlspecialchars($musica['titulo']); ?></span>
                            <?php if ($musica['destaque']): ?>
                                <span class="track-badge"><?php echo translateText('Destaque'); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="track-col-duration">
                            <span><?php echo $musica['duracao']; ?></span>
                        </div>
                        
                        <div class="track-col-streams">
                            <span><?php echo $musica['streams']; ?></span>
                        </div>
                        
                        <div class="track-col-actions">
                            <button class="track-action-btn" onclick="editTrack(<?php echo $musica['id']; ?>)" title="Editar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="track-action-btn track-delete" onclick="deleteTrack(<?php echo $musica['id']; ?>)" title="Excluir">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

    <!-- Modal: Editar Álbum -->
    <div class="modal-overlay" id="albumModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo translateText('Editar Álbum'); ?></h2>
                <button class="modal-close" onclick="closeAlbumModal()">✕</button>
            </div>
            <form id="albumForm" onsubmit="handleAlbumSubmit(event)">
                <div class="form-group">
                    <label for="albumTitulo"><?php echo translateText('Título'); ?> *</label>
                    <input type="text" id="albumTitulo" required>
                </div>
                
                <div class="form-group">
                    <label for="albumAno"><?php echo translateText('Ano'); ?> *</label>
                    <input type="number" id="albumAno" min="1900" max="2100" required>
                </div>
                
                <div class="form-group">
                    <label for="albumTipo"><?php echo translateText('Tipo'); ?> *</label>
                    <select id="albumTipo" required>
                        <option value="Álbum">Álbum</option>
                        <option value="EP">EP</option>
                        <option value="Single">Single</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="albumGravadora"><?php echo translateText('Gravadora'); ?></label>
                    <input type="text" id="albumGravadora">
                </div>
                
                <div class="form-group">
                    <label for="albumDescricao"><?php echo translateText('Descrição'); ?></label>
                    <textarea id="albumDescricao" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="albumCapa"><?php echo translateText('URL da Capa'); ?></label>
                    <input type="url" id="albumCapa" placeholder="https://...">
                    <img id="capaPreview" class="preview-image" style="display: none;">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeAlbumModal()">
                        <?php echo translateText('Cancelar'); ?>
                    </button>
                    <button type="submit" class="btn-modal-save">
                        <?php echo translateText('Salvar Alterações'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Adicionar/Editar Música -->
    <div class="modal-overlay" id="musicModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="musicModalTitle"><?php echo translateText('Adicionar Música'); ?></h2>
                <button class="modal-close" onclick="closeMusicModal()">✕</button>
            </div>
            <form id="musicForm" onsubmit="handleMusicSubmit(event)">
                <input type="hidden" id="musicId">
                
                <div class="form-group">
                    <label for="musicTitulo"><?php echo translateText('Título da Música'); ?> *</label>
                    <input type="text" id="musicTitulo" required>
                </div>
                
                <div class="form-group">
                    <label for="musicDuracao"><?php echo translateText('Duração (MM:SS)'); ?> *</label>
                    <input type="text" id="musicDuracao" placeholder="3:45" pattern="\d{1,2}:\d{2}" required>
                </div>
                
                <div class="form-group">
                    <label for="musicStreams"><?php echo translateText('Streams'); ?></label>
                    <input type="text" id="musicStreams" placeholder="0">
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="musicDestaque">
                    <label for="musicDestaque"><?php echo translateText('Marcar como destaque'); ?></label>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeMusicModal()">
                        <?php echo translateText('Cancelar'); ?>
                    </button>
                    <button type="submit" class="btn-modal-save">
                        <?php echo translateText('Salvar'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
    $modalConfig = [
        'returnUrl' => 'detalhesLancamento.php',
        'preserveParams' => ['id']
    ];
    require_once 'languageModal.php';
    require_once 'footerCadArtista.php';
    ?>

    <script>
        // Dados do álbum
        let album = <?php echo $lancamentoJson; ?>;
        
        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            setupMobileMenu();
            
            // Preview de imagem
            const capaInput = document.getElementById('albumCapa');
            if (capaInput) {
                capaInput.addEventListener('input', function() {
                    const preview = document.getElementById('capaPreview');
                    if (this.value) {
                        preview.src = this.value;
                        preview.style.display = 'block';
                    } else {
                        preview.style.display = 'none';
                    }
                });
            }
        });
        
        // Renderizar lista de músicas
        function renderTracksList() {
            const container = document.getElementById('tracksList');
            if (!album.musicas || album.musicas.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: rgba(255,255,255,0.6); padding: 2rem;">Nenhuma música adicionada ainda.</p>';
                return;
            }
            
            container.innerHTML = album.musicas.map(musica => `
                <div class="track-item" data-id="${musica.id}">
                    <div class="track-col-number">
                        <span>${musica.numero}</span>
                    </div>
                    
                    <div class="track-col-title">
                        <span class="track-title">${musica.titulo}</span>
                        ${musica.destaque ? '<span class="track-badge"><?php echo translateText('Destaque'); ?></span>' : ''}
                    </div>
                    
                    <div class="track-col-duration">
                        <span>${musica.duracao}</span>
                    </div>
                    
                    <div class="track-col-streams">
                        <span>${musica.streams}</span>
                    </div>
                    
                    <div class="track-col-actions">
                        <button class="track-action-btn" onclick="editTrack(${musica.id})" title="Editar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button class="track-action-btn track-delete" onclick="deleteTrack(${musica.id})" title="Excluir">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');
        }
        
        // Editar álbum
        function editAlbum() {
            document.getElementById('albumTitulo').value = album.titulo;
            document.getElementById('albumAno').value = album.ano;
            document.getElementById('albumTipo').value = album.tipo;
            document.getElementById('albumGravadora').value = album.gravadora || '';
            document.getElementById('albumDescricao').value = album.descricao || '';
            document.getElementById('albumCapa').value = album.capa || '';
            
            if (album.capa) {
                document.getElementById('capaPreview').src = album.capa;
                document.getElementById('capaPreview').style.display = 'block';
            }
            
            document.getElementById('albumModal').classList.add('active');
        }
        
        function closeAlbumModal() {
            document.getElementById('albumModal').classList.remove('active');
        }
        
        function handleAlbumSubmit(event) {
            event.preventDefault();
            
            album.titulo = document.getElementById('albumTitulo').value;
            album.ano = parseInt(document.getElementById('albumAno').value);
            album.tipo = document.getElementById('albumTipo').value;
            album.gravadora = document.getElementById('albumGravadora').value;
            album.descricao = document.getElementById('albumDescricao').value;
            album.capa = document.getElementById('albumCapa').value;
            
            // Atualizar interface
            document.querySelector('.album-title').textContent = album.titulo;
            document.querySelector('.album-type').textContent = album.tipo;
            document.querySelector('.album-description').textContent = album.descricao;
            document.querySelectorAll('.album-cover img').forEach(img => img.src = album.capa);
            document.querySelector('.album-background').style.backgroundImage = `url('${album.capa}')`;
            
            const metaYear = document.querySelector('.album-meta span:first-child');
            if (metaYear) metaYear.textContent = album.ano;
            
            closeAlbumModal();
            alert('<?php echo translateText('Álbum atualizado com sucesso!'); ?>');
        }
        
        // Adicionar música
        function openAddMusicModal() {
            document.getElementById('musicModalTitle').textContent = '<?php echo translateText('Adicionar Música'); ?>';
            document.getElementById('musicForm').reset();
            document.getElementById('musicId').value = '';
            document.getElementById('musicModal').classList.add('active');
        }
        
        // Editar música
        function editTrack(id) {
            const music = album.musicas.find(m => m.id === id);
            if (!music) return;
            
            document.getElementById('musicModalTitle').textContent = '<?php echo translateText('Editar Música'); ?>';
            document.getElementById('musicId').value = music.id;
            document.getElementById('musicTitulo').value = music.titulo;
            document.getElementById('musicDuracao').value = music.duracao;
            document.getElementById('musicStreams').value = music.streams || '0';
            document.getElementById('musicDestaque').checked = music.destaque || false;
            
            document.getElementById('musicModal').classList.add('active');
        }
        
        function closeMusicModal() {
            document.getElementById('musicModal').classList.remove('active');
        }
        
        function handleMusicSubmit(event) {
            event.preventDefault();
            
            const musicId = document.getElementById('musicId').value;
            
            if (!album.musicas) album.musicas = [];
            
            const musicData = {
                id: musicId ? parseInt(musicId) : Date.now(),
                numero: album.musicas.length + 1,
                titulo: document.getElementById('musicTitulo').value,
                duracao: document.getElementById('musicDuracao').value,
                streams: document.getElementById('musicStreams').value || '0',
                destaque: document.getElementById('musicDestaque').checked
            };
            
            if (musicId) {
                // Editar
                const index = album.musicas.findIndex(m => m.id === parseInt(musicId));
                if (index !== -1) {
                    musicData.numero = album.musicas[index].numero;
                    album.musicas[index] = musicData;
                }
                alert('<?php echo translateText('Música atualizada com sucesso!'); ?>');
            } else {
                // Adicionar
                album.musicas.push(musicData);
                alert('<?php echo translateText('Música adicionada com sucesso!'); ?>');
            }
            
            // Atualizar contagem
            const trackCount = document.querySelector('.album-meta span:nth-child(3)');
            if (trackCount) {
                trackCount.textContent = `${album.musicas.length} <?php echo translateText('faixas'); ?>`;
            }
            
            closeMusicModal();
            renderTracksList();
        }
        
        // Excluir música
        function deleteTrack(id) {
            if (!confirm('<?php echo translateText('Tem certeza que deseja excluir esta música?'); ?>')) {
                return;
            }
            
            album.musicas = album.musicas.filter(m => m.id !== id);
            
            // Renumerar músicas
            album.musicas.forEach((music, index) => {
                music.numero = index + 1;
            });
            
            // Atualizar contagem
            const trackCount = document.querySelector('.album-meta span:nth-child(3)');
            if (trackCount) {
                trackCount.textContent = `${album.musicas.length} <?php echo translateText('faixas'); ?>`;
            }
            
            renderTracksList();
            alert('<?php echo translateText('Música excluída com sucesso!'); ?>');
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
            
            // Fechar modais ao clicar fora
            if (event.target.classList.contains('modal-overlay')) {
                closeAlbumModal();
                closeMusicModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const langModal = document.getElementById('languageModal');
                if (langModal && langModal.style.display === 'block') {
                    toggleLanguageModal();
                }
                closeAlbumModal();
                closeMusicModal();
            }
        });

        // Mobile Menu
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