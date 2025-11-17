<?php
if (!defined('SITE_NAME')) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <link rel="stylesheet" href="../css/style-headerCadArtista.css">
    <title><?php echo $pageTitle ?? translate('home'); ?> | Giana Station for Artists</title>
</head>
<body>
    <header class="header" id="header">
        <section class="header-content">
            <a href="homePaginaCadastro.php" class="logo">
                <img src="../img/GA-Station.png" alt="Giana Station" style="width: 40px; height: 40px;">
                <span>for Artists</span>
            </a>

            <nav class="nav-desktop">
                <a href="homePaginaCadastro.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
                <a href="cadastrarArtistaMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_here'); ?></a>
                <a href="formCadArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_artist'); ?></a>
                <a href="formCadMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_music'); ?></a>    
            </nav>

            <section class="header-actions">
                <section class="language-selector">
                    <button class="btn-language" onclick="toggleLanguageModal()">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </button>
                </section>

                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="btn-ghost"><?php echo translate('sign_out'); ?></a>
                <?php else: ?>
                    <a href="login.php?lang=<?php echo $currentLang; ?>" class="btn-ghost"><?php echo translate('sign_in'); ?></a>
                <?php endif; ?>

                <a href="cadastrarArtistaMusica.php?lang=<?php echo $currentLang; ?>" class="btn-primary"><?php echo translate('get_started'); ?></a>

                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Menu"> 
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
            <a href="homePaginaCadastro.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('home'); ?></a>
            <a href="cadastrarArtistaMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_here'); ?></a>
            <a href="formCadArtista.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_artist'); ?></a>
            <a href="formCadMusica.php?lang=<?php echo $currentLang; ?>" class="nav-link"><?php echo translate('register_music'); ?></a> 
            
            <section class="mobile-actions">
                <section class="language-selector">
                    <button class="btn-language" onclick="toggleLanguageModal()">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <span class="language-text"><?php echo $availableLanguages[$currentLang]['name']; ?></span>
                    </button>
                </section>
                
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="btn-ghost"><?php echo translate('sign_out'); ?></a>
                <?php else: ?>
                    <a href="login.php?lang=<?php echo $currentLang; ?>" class="btn-ghost"><?php echo translate('sign_in'); ?></a>
                <?php endif; ?>
                
                <a href="cadastrarArtistaMusica.php?lang=<?php echo $currentLang; ?>" class="btn-primary"><?php echo translate('get_started'); ?></a>
            </section>
        </nav>
    </header>

    <div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="toggleMobileMenu()"></div>

    <?php
    $modalConfig = [
        'returnUrl' => $_SERVER['PHP_SELF'],
        'preserveParams' => []
    ];
    require_once 'languageModal.php';
    ?>

    <script>
        function toggleMobileMenu() {
            const navMobile = document.getElementById('navMobile');
            const overlay = document.getElementById('mobileMenuOverlay');
            const menuIcon = document.querySelector('.menu-icon');
            const closeIcon = document.querySelector('.close-icon');
            
            const isActive = navMobile.classList.contains('active');
            
            navMobile.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('menu-open');
            
            if (menuIcon) menuIcon.style.display = isActive ? 'block' : 'none';
            if (closeIcon) closeIcon.style.display = isActive ? 'none' : 'block';
        }
    </script>
