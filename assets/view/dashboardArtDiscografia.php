<?php
require_once 'config.php';
$pageTitle = translateText('Discografia');

// Dados de exemplo - substituir por dados do banco
$discografia = [
    'albums' => [
        [
            'id' => 1,
            'titulo' => 'Trevo',
            'ano' => 2017,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
            'tipo' => 'Álbum',
            'gravadora' => 'Universal Music',
            'descricao' => 'Álbum de estreia da dupla com grandes sucessos.',
            'faixas' => 14,
            'streams' => '2.5M',
            'musicas' => [
                ['id' => 1, 'numero' => 1, 'titulo' => 'Trevo (Tu)', 'duracao' => '3:45', 'streams' => '450K', 'destaque' => true],
                ['id' => 2, 'numero' => 2, 'titulo' => 'Não Sinto Nada', 'duracao' => '3:28', 'streams' => '320K', 'destaque' => false],
            ]
        ],
        [
            'id' => 2,
            'titulo' => 'O Tempo É Agora',
            'ano' => 2018,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2735d7cf1a8508aa994d4bde5c8',
            'tipo' => 'Álbum',
            'gravadora' => 'Universal Music',
            'descricao' => 'Segundo álbum de estúdio com 12 faixas inéditas.',
            'faixas' => 12,
            'streams' => '3.1M',
            'musicas' => [
                ['id' => 3, 'numero' => 1, 'titulo' => 'Tempo', 'duracao' => '3:52', 'streams' => '280K', 'destaque' => true],
                ['id' => 4, 'numero' => 2, 'titulo' => 'Agora', 'duracao' => '4:02', 'streams' => '245K', 'destaque' => false],
            ]
        ],
        [
            'id' => 3,
            'titulo' => 'Esquinas',
            'ano' => 2024,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
            'tipo' => 'Álbum',
            'gravadora' => 'Universal Music',
            'descricao' => 'O terceiro álbum de estúdio da dupla traz 12 faixas inéditas.',
            'faixas' => 12,
            'streams' => '1.8M',
            'musicas' => [
                ['id' => 5, 'numero' => 1, 'titulo' => 'Esquinas', 'duracao' => '3:45', 'streams' => '450K', 'destaque' => true],
                ['id' => 6, 'numero' => 2, 'titulo' => 'Singular', 'duracao' => '4:02', 'streams' => '320K', 'destaque' => false],
            ]
        ]
    ],
    'eps' => [
        [
            'id' => 4,
            'titulo' => 'Ao Vivo em São Paulo',
            'ano' => 2019,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b273190aaad879fd91cebab37efd',
            'tipo' => 'EP',
            'gravadora' => 'Universal Music',
            'descricao' => 'EP ao vivo gravado em São Paulo.',
            'faixas' => 6,
            'streams' => '890K',
            'musicas' => []
        ]
    ],
    'singles' => [
        [
            'id' => 5,
            'titulo' => 'Trevo (Tu)',
            'ano' => 2017,
            'capa' => 'https://i.scdn.co/image/ab67616d0000b2732d9442517e36cd23c60efe50',
            'tipo' => 'Single',
            'gravadora' => 'Universal Music',
            'descricao' => 'Single de estreia da dupla.',
            'faixas' => 1,
            'streams' => '450K',
            'musicas' => []
        ]
    ]
];

// Codificar dados para JavaScript
$discografiaJson = json_encode(array_merge($discografia['albums'], $discografia['eps'], $discografia['singles']));
?>

<link rel="stylesheet" href="../css/style-dashboardArtDiscografia.css">

<!DOCTYPE html>
<body>
    <nav class="navbar">
        <section class="navbar-content">
            <section class="navbar-left">
                <a href="pagInicial.php" class="artist-profile">
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
  
    <main class="main-content">
        <section class="page-header">
            <div>
                <h1><?php echo translateText('Discografia'); ?></h1>
                <p><?php echo translateText('Gerencie seus álbuns, EPs e singles'); ?></p>
            </div>
            <button class="btn-primary" id="btnAddRelease">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                <span><?php echo translateText('Adicionar Lançamento'); ?></span>
            </button>
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
                    <p class="stat-value" id="albumCount"><?php echo count($discografia['albums']); ?></p>
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
                    <p class="stat-value" id="epCount"><?php echo count($discografia['eps']); ?></p>
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
                    <p class="stat-value" id="singleCount"><?php echo count($discografia['singles']); ?></p>
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
        <section id="releasesContainer"></section>
    </main>

    <!-- Modal: Adicionar/Editar Álbum -->
    <div class="modal-overlay" id="albumModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="albumModalTitle"><?php echo translateText('Adicionar Lançamento'); ?></h2>
                <button class="modal-close" onclick="closeAlbumModal()">✕</button>
            </div>
            <form id="albumForm" onsubmit="handleAlbumSubmit(event)">
                <input type="hidden" id="albumId">
                
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
                        <?php echo translateText('Salvar'); ?>
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
                <input type="hidden" id="musicAlbumId">
                
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
        'returnUrl' => 'dashboardArtDiscografia.php',
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    require_once 'footerCadArtista.php';
    ?>

    <script>
        // Dados iniciais
        let albums = <?php echo $discografiaJson; ?>;
        let currentFilter = 'all';
        let selectedAlbum = null;
        
        // Inicializar página
        document.addEventListener('DOMContentLoaded', function() {
            renderReleases();
            updateStats();
            setupFilters();
            setupMobileMenu();
            
            // Preview de imagem
            document.getElementById('albumCapa').addEventListener('input', function() {
                const preview = document.getElementById('capaPreview');
                if (this.value) {
                    preview.src = this.value;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });
            
            // Botão adicionar lançamento
            document.getElementById('btnAddRelease').addEventListener('click', openAddAlbumModal);
        });
        
        // Renderizar lançamentos
        function renderReleases() {
            const container = document.getElementById('releasesContainer');
            const filtered = currentFilter === 'all' ? albums : albums.filter(a => a.tipo === currentFilter);
            
            if (filtered.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: rgba(255,255,255,0.6); padding: 3rem;">Nenhum lançamento encontrado.</p>';
                return;
            }
            
            container.innerHTML = `
                <section class="releases-grid">
                    ${filtered.map(album => `
                        <article class="release-card" data-id="${album.id}">
                            <div class="release-actions">
                                <button class="btn-icon" onclick="openEditAlbumModal(${album.id})" title="Editar">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteAlbum(${album.id})" title="Excluir">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="release-cover" onclick="viewAlbum(${album.id})">
                                <img src="${album.capa}" alt="${album.titulo}">
                            </div>
                            <div class="release-info">
                                <span class="release-badge ${getBadgeClass(album.tipo)}">${album.tipo}</span>
                                <h3>${album.titulo}</h3>
                                <p class="release-year">${album.ano}</p>
                                <div class="release-meta">
                                    <span>${album.musicas?.length || album.faixas || 0} faixas</span>
                                    ${album.streams ? '<span>•</span><span>' + album.streams + ' streams</span>' : ''}
                                </div>
                            </div>
                        </article>
                    `).join('')}
                </section>
            `;
        }
        
        function getBadgeClass(tipo) {
            if (tipo === 'EP') return 'badge-blue';
            if (tipo === 'Single') return 'badge-purple';
            return '';
        }
        
        // Atualizar estatísticas
        function updateStats() {
            document.getElementById('albumCount').textContent = albums.filter(a => a.tipo === 'Álbum').length;
            document.getElementById('epCount').textContent = albums.filter(a => a.tipo === 'EP').length;
            document.getElementById('singleCount').textContent = albums.filter(a => a.tipo === 'Single').length;
        }
        
        // Filtros
        function setupFilters() {
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentFilter = tab.dataset.filter;
                    renderReleases();
                });
            });
        }
        
        // Visualizar álbum
        function viewAlbum(id) {
            const album = albums.find(a => a.id === id);
            if (!album) return;
            
            window.location.href = `detalhesLancamento.php?id=${id}&lang=<?php echo $currentLang; ?>`;
        }
        
        // Modal Álbum
        function openAddAlbumModal() {
            document.getElementById('albumModalTitle').textContent = '<?php echo translateText('Adicionar Lançamento'); ?>';
            document.getElementById('albumForm').reset();
            document.getElementById('albumId').value = '';
            document.getElementById('capaPreview').style.display = 'none';
            document.getElementById('albumModal').classList.add('active');
        }
        
        function openEditAlbumModal(id) {
            const album = albums.find(a => a.id === id);
            if (!album) return;
            
            document.getElementById('albumModalTitle').textContent = '<?php echo translateText('Editar Lançamento'); ?>';
            document.getElementById('albumId').value = album.id;
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
            
            const id = document.getElementById('albumId').value;
            const albumData = {
                id: id ? parseInt(id) : Date.now(),
                titulo: document.getElementById('albumTitulo').value,
                ano: parseInt(document.getElementById('albumAno').value),
                tipo: document.getElementById('albumTipo').value,
                gravadora: document.getElementById('albumGravadora').value,
                descricao: document.getElementById('albumDescricao').value,
                capa: document.getElementById('albumCapa').value || 'https://via.placeholder.com/300',
                faixas: 0,
                streams: '0',
                musicas: []
            };
            
            if (id) {
                // Editar
                const index = albums.findIndex(a => a.id === parseInt(id));
                if (index !== -1) {
                    albumData.musicas = albums[index].musicas || [];
                    albumData.faixas = albumData.musicas.length;
                    albums[index] = albumData;
                }
                alert('<?php echo translateText('Álbum atualizado com sucesso!'); ?>');
            } else {
                // Adicionar
                albums.push(albumData);
                alert('<?php echo translateText('Álbum adicionado com sucesso!'); ?>');
            }
            
            closeAlbumModal();
            renderReleases();
            updateStats();
        }
        
        // Excluir álbum
        function deleteAlbum(id) {
            if (!confirm('<?php echo translateText('Tem certeza que deseja excluir este lançamento?'); ?>')) {
                return;
            }
            
            albums = albums.filter(a => a.id !== id);
            renderReleases();
            updateStats();
            alert('<?php echo translateText('Álbum excluído com sucesso!'); ?>');
        }
        
        // Modal Música
        function openAddMusicModal(albumId) {
            selectedAlbum = albums.find(a => a.id === albumId);
            if (!selectedAlbum) return;
            
            document.getElementById('musicModalTitle').textContent = '<?php echo translateText('Adicionar Música'); ?>';
            document.getElementById('musicForm').reset();
            document.getElementById('musicId').value = '';
            document.getElementById('musicAlbumId').value = albumId;
            document.getElementById('musicModal').classList.add('active');
        }
        
        function openEditMusicModal(albumId, musicId) {
            const album = albums.find(a => a.id === albumId);
            if (!album) return;
            
            const music = album.musicas.find(m => m.id === musicId);
            if (!music) return;
            
            selectedAlbum = album;
            
            document.getElementById('musicModalTitle').textContent = '<?php echo translateText('Editar Música'); ?>';
            document.getElementById('musicId').value = music.id;
            document.getElementById('musicAlbumId').value = albumId;
            document.getElementById('musicTitulo').value = music.titulo;
            document.getElementById('musicDuracao').value = music.duracao;
            document.getElementById('musicStreams').value = music.streams || '0';
            document.getElementById('musicDestaque').checked = music.destaque || false;
            
            document.getElementById('musicModal').classList.add('active');
        }
        
        function closeMusicModal() {
            document.getElementById('musicModal').classList.remove('active');
            selectedAlbum = null;
        }
        
        function handleMusicSubmit(event) {
            event.preventDefault();
            
            const albumId = parseInt(document.getElementById('musicAlbumId').value);
            const musicId = document.getElementById('musicId').value;
            
            const album = albums.find(a => a.id === albumId);
            if (!album) return;
            
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
            
            // Atualizar contagem de faixas
            album.faixas = album.musicas.length;
            
            closeMusicModal();
            renderReleases();
        }
        
        // Excluir música
        function deleteMusic(albumId, musicId) {
            if (!confirm('<?php echo translateText('Tem certeza que deseja excluir esta música?'); ?>')) {
                return;
            }
            
            const album = albums.find(a => a.id === albumId);
            if (!album) return;
            
            album.musicas = album.musicas.filter(m => m.id !== musicId);
            album.faixas = album.musicas.length;
            
            // Renumerar músicas
            album.musicas.forEach((music, index) => {
                music.numero = index + 1;
            });
            
            renderReleases();
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