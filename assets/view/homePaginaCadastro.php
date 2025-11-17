<?php 
require_once 'config.php';
$pageTitle = translate('home');

// Verificar se usuário está logado e se é artista
$isLoggedIn = isset($_SESSION['user_id']);
$isArtist = isset($_SESSION['is_artist']) && $_SESSION['is_artist'];

// Definir URL do botão "Comece agora"
if ($isLoggedIn && $isArtist) {
    $ctaUrl = "dashboardArtista.php?lang=" . $currentLang;
} else if ($isLoggedIn && !$isArtist) {
    $ctaUrl = "cadastrarArtistaMusica.php?lang=" . $currentLang;
} else {
    $ctaUrl = "cadastrarArtistaMusica.php?lang=" . $currentLang;
}
?>

<link rel="stylesheet" href="../css/style-homeCadArtista.css">

<?php require_once 'headerCadArtista.php'; ?>

<main>
    <section class="hero">
        <video class="hero-video" id="heroVideo" autoplay loop muted playsinline>
            <source src="../video/video-artista.mp4" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <section class="hero-content">
            <section class="hero-text">
                <h1><?php echo translateText('Onde o que mais importa é a sua música'); ?></h1>
                <p><?php echo translateText('Construa sua base de fãs, desenvolva seu negócio e crie um mundo ao redor da sua música.'); ?></p>
            </section>

            <section class="posicao-btn">
                <button class="video-control" id="videoControl" onclick="toggleVideo()">
                    <svg class="icon pause-icon" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="6" y="4" width="4" height="16"/>
                        <rect x="14" y="4" width="4" height="16"/>
                    </svg>
                    <svg class="icon play-icon hidden" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </button>
            </section>

            <section class="nav-cards">
                <button class="nav-card" onclick="scrollToSection('amplify')">
                    <h3><?php echo translateText('Amplifique sua música'); ?></h3>
                    <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <polyline points="19 12 12 19 5 12"/>
                    </svg>
                </button>
                
                <button class="nav-card" onclick="scrollToSection('connect')">
                    <h3><?php echo translateText('Se conecte com os fãs'); ?></h3>
                    <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <polyline points="19 12 12 19 5 12"/>
                    </svg>
                </button>
                
                <button class="nav-card" onclick="scrollToSection('grow')">
                    <h3><?php echo translateText('Amplie seu negócio'); ?></h3>
                    <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <polyline points="19 12 12 19 5 12"/>
                    </svg>
                </button>
                
                <button class="nav-card" onclick="scrollToSection('audience')">
                    <h3><?php echo translateText('Entenda seu público'); ?></h3>
                    <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <polyline points="19 12 12 19 5 12"/>
                    </svg>
                </button>
            </section>
        </section>
    </section>

    <section id="amplify" class="split-section">
        <section class="split-image">
            <section class="split-image-inner">
                <video class="video-section" autoplay loop muted playsinline>
                    <source src="../video/video-1.mp4" type="video/mp4">
                </video>
            </section>
        </section>

        <section class="split-content">
            <section class="split-content-inner">
                <h2><?php echo translate('amplify_music'); ?></h2>
                <p class="section-description">
                    Aumente o som com o Kit de Campanha, um conjunto de ferramentas feitas para impulsionar métricas importantes para artistas e profissionais de marketing musical.
                </p>

                <section class="feature-list">
                    <section class="feature-item">
                        <p>
                            <svg viewBox="0 0 16 16" width="16" height="16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm11.748-1.97a.75.75 0 0 0-1.06-1.06l-4.47 4.47-1.405-1.406a.75.75 0 1 0-1.061 1.06l2.466 2.467 5.53-5.53z" fill="#d518ee"></path></svg>
                            <span>Marquee faz seu novo lançamento se tornar imperdível com uma recomendação em tela cheia.</span>
                        </p>
                    </section>
                    <section class="feature-item">
                        <p>
                            <svg viewBox="0 0 16 16" width="16" height="16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm11.748-1.97a.75.75 0 0 0-1.06-1.06l-4.47 4.47-1.405-1.406a.75.75 0 1 0-1.061 1.06l2.466 2.467 5.53-5.53z" fill="#d518ee"></path></svg>
                            <span>O Showcase promove sua música no Início do Spotify com um título selecionado.</span>
                        </p>
                    </section>
                    <section class="feature-item">
                        <p>
                            <svg viewBox="0 0 16 16" width="16" height="16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm11.748-1.97a.75.75 0 0 0-1.06-1.06l-4.47 4.47-1.405-1.406a.75.75 0 1 0-1.061 1.06l2.466 2.467 5.53-5.53z" fill="#d518ee"></path></svg>
                            <span>O Discovery Mode pode impulsionar sua música em playlists personalizadas.</span>
                        </p>
                    </section>
                </section>
            </section>
        </section>
    </section>

    <section id="connect" class="split-section2">
        <section class="split-content">
            <section class="split-content-inner">
                <h2><?php echo translate('connect_fans'); ?></h2>
                <p class="section-description">
                    Convide os ouvintes para seu mundo de criatividade. Personalize seu perfil do artista, crie vídeos e recursos visuais.
                </p>
            </section>
        </section>

        <section class="split-image">
            <section class="split-image-inner">
                <video class="video-section" autoplay loop muted playsinline>
                    <source src="../video/video-2.mp4" type="video/mp4">
                </video>
            </section>
        </section>
    </section>

    <section id="grow" class="split-section">
        <section class="split-image">
            <section class="split-image-inner">
                <video class="video-section" autoplay loop muted playsinline>
                    <source src="../video/video-3.mp4" type="video/mp4">
                </video>
            </section>
        </section>

        <section class="split-content">
            <section class="split-content-inner">
                <h2><?php echo translate('grow_business'); ?></h2>
                <p class="section-description">
                    Existem muitas maneiras de gerar receita como artista no Spotify. Embora o Loud & Clear seja sua principal fonte de dados.
                </p>
            </section>
        </section>
    </section>

    <section id="audience" class="split-section2">
        <section class="split-content">
            <section class="split-content-inner">
                <h2><?php echo translate('understand_audience'); ?></h2>
                <p class="section-description">
                    Confira dados de músicas, playlists e público para alcançar seus objetivos.
                </p>
            </section>
        </section>

        <section class="split-image">
            <section class="split-image-inner">
                <video class="video-section" autoplay loop muted playsinline>
                    <source src="../video/video-4.mp4" type="video/mp4">
                </video>
            </section>
        </section>
    </section>

    <section class="cta-banner">
        <section class="cta-content">
            <h2>Bora criar sua conta da Giana Station for Artists?</h2>
            <a href="<?php echo $ctaUrl; ?>" class="btn-seguir">
                Comece agora
            </a>
        </section>
    </section>
</main>

<script>
function toggleVideo() {
    const video = document.getElementById('heroVideo');
    const pauseIcon = document.querySelector('.pause-icon');
    const playIcon = document.querySelector('.play-icon');
    
    if (video.paused) {
        video.play();
        pauseIcon.classList.remove('hidden');
        playIcon.classList.add('hidden');
    } else {
        video.pause();
        pauseIcon.classList.add('hidden');
        playIcon.classList.remove('hidden');
    }
}

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

window.addEventListener('scroll', function() {
    const header = document.getElementById('header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>

<?php require_once 'footerCadArtista.php'; ?>