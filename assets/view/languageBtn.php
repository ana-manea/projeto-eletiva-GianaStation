<?php
if (!defined('SITE_NAME')) {
    die('Acesso direto não permitido');
}

$defaultButtonConfig = [
    'position' => 'absolute',
    'showText' => true,
    'style' => ''
];

$buttonConfig = isset($buttonConfig) ? array_merge($defaultButtonConfig, $buttonConfig) : $defaultButtonConfig;

$baseStyle = "background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 20px; color: white; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s;";

$positionStyle = '';
if ($buttonConfig['position'] === 'absolute') {
    $positionStyle = "position: absolute; top: 20px; right: 20px; z-index: 100;";
}

$finalStyle = $baseStyle . $positionStyle . $buttonConfig['style'];
?>

<section style="<?php echo $positionStyle; ?>">
    <button class="btn-language" 
            onclick="toggleLanguageModal()" 
            style="<?php echo $baseStyle . $buttonConfig['style']; ?>"
            onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='rgba(213, 24, 238, 0.5)';"
            onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.borderColor='rgba(255, 255, 255, 0.2)';">
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