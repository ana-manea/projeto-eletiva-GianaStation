<?php
session_start();

define('SITE_NAME', 'Giana Stataion');
/*Se necessário, podemos adicionar o endereço aqui, mas como varia para cada máquina que está sendo utilizado, vou deixar sem por hora */

$availableLanguages = [
    'pt-BR' => ['name' => 'Português do Brasil', 'code' => 'pt-BR'],
    'en-GB' => ['name' => 'English', 'code' => 'en-GB'],
    'es-ES' => ['name' => 'Español', 'code' => 'es-ES'],
    'fr-FR' => ['name' => 'Français', 'code' => 'fr-FR'],
    'de-DE' => ['name' => 'Deutsch', 'code' => 'de-DE'],
    'it-IT' => ['name' => 'Italiano', 'code' => 'it-IT'],
    'ja-JP' => ['name' => '日本語', 'code' => 'ja-JP']
];

if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $availableLanguages)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'] ?? 'pt-BR';
$langCode = strtolower(explode('-', $currentLang)[0]);

$isLoggedIn = isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'];

if (!isset($_SESSION['translation_cache'])) {
    $_SESSION['translation_cache'] = [];
}

function translateText($text, $toLang = null) {
    global $currentLang;
    $toLang = $toLang ?? $currentLang;
    
    if ($toLang === 'pt-BR') {
        return $text;
    }
    
    $cacheKey = md5($text . '_' . $toLang);
    if (isset($_SESSION['translation_cache'][$cacheKey])) {
        return $_SESSION['translation_cache'][$cacheKey];
    }
    
    try {
        $url = "https://api.mymemory.translated.net/get?q=" . urlencode($text) . "&langpair=pt-BR|" . $toLang;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        curl_close($ch);
        
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['responseData']['translatedText'])) {
                $translation = $data['responseData']['translatedText'];
                
                if (count($_SESSION['translation_cache']) >= 100) {
                    $_SESSION['translation_cache'] = array_slice($_SESSION['translation_cache'], -50, 50, true);
                }
                $_SESSION['translation_cache'][$cacheKey] = $translation;
                
                return $translation;
            }
        }
    } catch (Exception $e) {
        error_log("Erro na tradução: " . $e->getMessage());
    }
    
    return $text;
}

function translate($key, $lang = null) {
    global $currentLang;
    $lang = $lang ?? $currentLang;
    
    $translations = [
        'pt-BR' => [
            'home' => 'Home',
            'register_here' => 'Cadastre aqui',
            'register_artist' => 'Cadastrar Artista',
            'register_music' => 'Cadastrar Música',
            'sign_in' => 'Entrar',
            'sign_out' => 'Sair',
            'get_started' => 'Comece a usar',
            'back' => 'Voltar',
            'characters' => 'caracteres',
            
            'about' => 'Sobre',
            'press_media' => 'Imprensa e mídia',
            'services' => 'Serviços',
            'contact' => 'Fale conosco',
            'useful_links' => 'LINKS ÚTEIS',
            'creator_tools' => 'FERRAMENTAS PARA CRIADORES',
            'download_app' => 'BAIXAR O APP',
            'legal' => 'Legal',
            'privacy' => 'Privacidade',
            'cookies' => 'Cookies',
            'copyright' => '© 2025 Giana Station AB',
            

            'amplify_music' => 'Amplifique sua música',
            'connect_fans' => 'Se conecte com os fãs',
            'grow_business' => 'Amplie seu negócio',
            'understand_audience' => 'Entenda seu público',

            'page2_title' => 'Acesse o Giana Station for Artists',
            'page2_subtitle' => 'Primeiro, conta pra gente o que você quer fazer.',
            'register_artist_desc' => 'Registre seu perfil de artista e comece a compartilhar sua música',
            'register_music_desc' => 'Adicione suas músicas e alcance milhões de ouvintes',

            'form_title_artist' => 'Cadastrar Artista',
            'form_subtitle_artist' => 'Preencha os dados abaixo para criar seu perfil de artista',
            'artist_name' => 'Nome Artístico',
            'artist_name_placeholder' => 'Digite o nome artístico',
            'profile_cover' => 'Capa do Perfil',
            'profile_cover_help' => 'Imagem de capa (JPG ou PNG, máximo 10MB)',
            'music_genre' => 'Gênero Musical',
            'genre_placeholder' => 'Ex: Pop, Rock, Hip-Hop...',
            'biography' => 'Biografia',
            'bio_placeholder' => 'Conte um pouco sobre você e sua música...',
            'create_profile' => 'Criar Perfil',
            
            'form_title_music' => 'Cadastrar Música',
            'form_subtitle_music' => 'Preencha os dados abaixo para adicionar sua música',
            'music_title' => 'Título da Música',
            'music_title_placeholder' => 'Digite o título da música',
            'artist' => 'Artista',
            'artist_placeholder' => 'Nome do artista ou banda',
            'album' => 'Álbum',
            'album_placeholder' => 'Nome do álbum',
            'type' => 'Tipo',
            'year' => 'Ano',
            'duration' => 'Duração',
            'lyrics' => 'Letra',
            'lyrics_placeholder' => 'Cole a letra da música aqui...',
            'audio_file' => 'Arquivo de Áudio',
            'audio_help' => 'Formato MP3, WAV ou FLAC (máximo 50MB)',
            'cover_single' => 'Capa do Single/Álbum',
            'cover_help' => 'Imagem de capa (JPG ou PNG, máximo 10MB)',
            'submit_music' => 'Cadastrar Música',
            
            'login_title' => 'Entrar na Giana Station',
            'continue_google' => 'Continuar com Google',
            'continue_facebook' => 'Continuar com Facebook',
            'continue_apple' => 'Continuar com Apple',
            'continue_phone' => 'Continuar com número de telefone',
            'email_username' => 'E-mail ou nome de usuário',
            'email_username_placeholder' => 'Email ou nome de usuário',
            'continue' => 'Continuar',
            'no_account' => 'Não tem uma conta?',
            'sign_up' => 'Inscrever-se na Giana Station',
            'recaptcha_text' => 'Este site é protegido pelo reCAPTCHA e está sujeito à Política de Privacidade e aos Termos de Serviço do Google.',
            'login_password_title' => 'Entrar com senha',
            'password' => 'Senha',
            'password_placeholder' => 'Senha',
            'login_no_password' => 'Entrar sem senha',
            'login_with_password' => 'Entrar com senha',
            'verification_code_title' => 'Insira o código de 6 dígitos enviado para',
            'resend_code' => 'Reenviar Código',
        ],
        'en-GB' => [
            'home' => 'Home',
            'register_here' => 'Register here',
            'register_artist' => 'Register Artist',
            'register_music' => 'Register Music',
            'sign_in' => 'Sign In',
            'sign_out' => 'Sign Out',
            'get_started' => 'Get Started',
            'back' => 'Back',
            'characters' => 'characters',
            
            'about' => 'About',
            'press_media' => 'Press & Media',
            'services' => 'Services',
            'contact' => 'Contact Us',
            'useful_links' => 'USEFUL LINKS',
            'creator_tools' => 'CREATOR TOOLS',
            'download_app' => 'DOWNLOAD APP',
            'legal' => 'Legal',
            'privacy' => 'Privacy',
            'cookies' => 'Cookies',
            'copyright' => '© 2025 Giana Station AB',

            'amplify_music' => 'Amplify your music',
            'connect_fans' => 'Connect with fans',
            'grow_business' => 'Grow your business',
            'understand_audience' => 'Understand your audience',

            'page2_title' => 'Access Giana Station for Artists',
            'page2_subtitle' => 'First, tell us what you want to do.',
            'register_artist_desc' => 'Register your artist profile and start sharing your music',
            'register_music_desc' => 'Add your music and reach millions of listeners',
            
            'form_title_artist' => 'Register Artist',
            'form_subtitle_artist' => 'Fill in the details below to create your artist profile',
            'artist_name' => 'Artist Name',
            'artist_name_placeholder' => 'Enter your artist name',
            'profile_cover' => 'Profile Cover',
            'profile_cover_help' => 'Cover image (JPG or PNG, maximum 10MB)',
            'music_genre' => 'Music Genre',
            'genre_placeholder' => 'E.g.: Pop, Rock, Hip-Hop...',
            'biography' => 'Biography',
            'bio_placeholder' => 'Tell us about yourself and your music...',
            'create_profile' => 'Create Profile',
            
            'form_title_music' => 'Register Music',
            'form_subtitle_music' => 'Fill in the details below to add your music',
            'music_title' => 'Song Title',
            'music_title_placeholder' => 'Enter the song title',
            'artist' => 'Artist',
            'artist_placeholder' => 'Artist or band name',
            'album' => 'Album',
            'album_placeholder' => 'Album name',
            'type' => 'Type',
            'year' => 'Year',
            'duration' => 'Duration',
            'lyrics' => 'Lyrics',
            'lyrics_placeholder' => 'Paste the song lyrics here...',
            'audio_file' => 'Audio File',
            'audio_help' => 'MP3, WAV or FLAC format (maximum 50MB)',
            'cover_single' => 'Single/Album Cover',
            'cover_help' => 'Cover image (JPG or PNG, maximum 10MB)',
            'submit_music' => 'Submit Music',

            'login_title' => 'Sign in to Giana Station',
            'continue_google' => 'Continue with Google',
            'continue_facebook' => 'Continue with Facebook',
            'continue_apple' => 'Continue with Apple',
            'continue_phone' => 'Continue with phone number',
            'email_username' => 'Email or username',
            'email_username_placeholder' => 'Email or username',
            'continue' => 'Continue',
            'no_account' => "Don't have an account?",
            'sign_up' => 'Sign up for Giana Station',
            'recaptcha_text' => 'This site is protected by reCAPTCHA and is subject to Google Privacy Policy and Terms of Service.',
            'login_password_title' => 'Sign in with password',
            'password' => 'Password',
            'password_placeholder' => 'Password',
            'login_no_password' => 'Sign in without password',
            'login_with_password' => 'Sign in with password',
            'verification_code_title' => 'Enter the 6-digit code sent to',
            'resend_code' => 'Resend Code',
        ]
    ];
    
    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    
    if (isset($translations['pt-BR'][$key])) {
        return translateText($translations['pt-BR'][$key], $lang);
    }
    
    return translateText($key, $lang);
}

function url($path, $lang = null) {
    global $currentLang;
    $lang = $lang ?? $currentLang;
    return $path . '?lang=' . $lang;
}
?>