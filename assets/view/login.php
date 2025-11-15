<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/GA-Station.png">
    <script type="text/javascript" src="../projeto-eletiva-radinho/assets/scripts/script.js"></script>
    <title>Login | Giana Station</title>
</head>
<body>
    <section class="conteudo">
        <section class="cabecalho">
            <img src="../img/GA-Station.png">
            <h1>Entrar na Giana Station</h1>
        </section>

        <section class="conectar-btn">
            <button>
                <img src="../img/logo-google.png">
                Continuar com Google</button>

            <button>
                <img src="../img/logo-facebook-cicle.png">
                Continuar com Facebook</button>

            <button>
                <img src="../img/apple-logo.png">
                Continuar com Apple</button>
            <button>Continuar com número de telefone</button>
        </section>

        <div class="linha"></div>

        <form method="POST" action="../processamento/processamento.php">
            <label for="email-login">E-mail ou nome de usuário</label>
            <input type="text" name="email" id="email-login" placeholder="Email">
            
            <input type="submit" id="entrar-senha" value="Continuar" onclick="redirecionarSenha(this)">
            
        </form>
        <p class="linkCadastrar">
            Não tem uma conta?
            <a href="../view/cadastrarUsuario.php">Inscrever-se na Giana Station</a>
        </p>
    </section>

    <footer>
        <p>Este site é protegido pelo reCAPTCHA e está sujeito à Política de Privacidade e aos Termos de Serviço do Google.</p>
    </footer>
</body>
</html>