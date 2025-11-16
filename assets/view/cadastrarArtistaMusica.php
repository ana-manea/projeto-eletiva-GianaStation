<?php
require_once 'config.php';
$pageTitle = translate('register_here');
?>

<link rel="stylesheet" href="../css/style-cadArtistaMusica.css">

<?php require_once 'headerCadArtista.php'; ?>

<section class="container">
    <main class="main-content">
        <h1 class="main-title"><?php echo translate('page2_title'); ?></h1>
        <p class="main-subtitle"><?php echo translate('page2_subtitle'); ?></p>

        <section class="options-grid">
            <a href="formCadArtista.php?lang=<?php echo $currentLang; ?>" class="option-card">
                <section class="option-content">
                    <h2 class="option-title"><?php echo translate('register_artist'); ?></h2>
                    <section class="option-icon-wrapper">
                        <svg class="option-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                    </section>
                    <p class="option-description">
                        <?php echo translate('register_artist_desc'); ?>
                    </p>
                </section>
            </a>

            <a href="formCadMusica.php?lang=<?php echo $currentLang; ?>" class="option-card">
                <section class="option-content">
                    <h2 class="option-title"><?php echo translate('register_music'); ?></h2>
                    <section class="option-icon-wrapper">
                        <svg class="option-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18V5l12-2v13"/>
                            <circle cx="6" cy="18" r="3"/>
                            <circle cx="18" cy="16" r="3"/>
                        </svg>
                    </section>
                    <p class="option-description">
                        <?php echo translate('register_music_desc'); ?>
                    </p>
                </section>
            </a>
        </section>

        <section class="footer-links">
            <p class="footer-link-item">
                <a href="#" class="link-underline">Se a equipe já existir, peça acesso ao administrador.</a>
            </p>
            <p class="footer-link-item">
                <a href="#" class="link-underline">Não sabe qual escolher?</a>
            </p>
        </section>
    </main>
</section>

<?php require_once 'footerCadArtista.php'; ?>