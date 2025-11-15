<?php
if (!defined('SITE_NAME')) {
    die('Acesso direto não permitido');
}

$defaultConfig = [
    'returnUrl' => $_SERVER['PHP_SELF'],
    'preserveParams' => ['email']
];
?>

<section id="languageModal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
    <section style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); margin: 5% auto; padding: 2rem; border: 1px solid rgba(213, 24, 238, 0.3); border-radius: 16px; width: 90%; max-width: 500px; box-shadow: 0 8px 32px rgba(213, 24, 238, 0.3); position: relative;">
        <button onclick="toggleLanguageModal()" style="position: absolute; right: 1rem; top: 1rem; background: transparent; border: none; color: rgba(255, 255, 255, 0.6); font-size: 1.5rem; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; transition: color 0.3s;">
            ✕
        </button>
        
        <h2 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem; text-align: center; font-weight: 600;">
            Selecione o idioma / Select language
        </h2>
        
        <section style="display: flex; flex-direction: column; gap: 0.75rem;">
            <?php foreach ($availableLanguages as $code => $lang): ?>
                <a href="<?php echo buildLanguageUrl($code); ?>" 
                   style="background: <?php echo $code === $currentLang ? 'linear-gradient(135deg, #d518ee 0%, #e88bf5 100%)' : 'rgba(255, 255, 255, 0.05)'; ?>; color: white; border: 1px solid <?php echo $code === $currentLang ? '#d518ee' : 'rgba(255, 255, 255, 0.1)'; ?>; padding: 1rem 1.25rem; border-radius: 8px; font-size: 1rem; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: space-between; transition: all 0.3s;">
                    <span><?php echo $lang['name']; ?></span>
                    <?php if ($code === $currentLang): ?>
                        <span style="color: #d518ee;">✓</span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </section>
    </section>
</section>

<section style="<?php echo $positionStyle; ?>">
    <button class="btn-language" onclick="toggleLanguageModal()" style="<?php echo $baseStyle . $buttonConfig['style']; ?>">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
        </svg>
        <?php if ($buttonConfig['showText']): ?>
            <span><?php echo $availableLanguages[$currentLang]['name']; ?></span>
        <?php endif; ?>
    </button>
</section>

<script>
    function toggleLanguageModal() {
        const modal = document.getElementById('languageModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('languageModal');
        if (event.target === modal) {
            toggleLanguageModal();
        }
    }
</script>