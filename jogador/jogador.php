<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Jogador</title>
    <link rel="stylesheet" href="jogador.css">
    <!-- <link rel="stylesheet" href="css/header-home.css">
    <link rel="stylesheet" href="css/footer-home.css"> -->
</head>
<body>
    <!-- ########### HEADER INICIO ########### -->
    <!-- <header class="header">
        <h1><a href="index.html"><strong>A▪N▪G▪E▪E▪R</strong></a></h1>
        <ul class="header_nav">
            <li><a class="header_nav_link" href="login.php"><h3>Login</h3></a></li>
            <li class="dropdown">
                <a class="header_nav_link" href="Servico.html"><h3>Serviços</h3></a>

            </li>
            <li><a class="header_nav_link" href="#final"><h3>Ajuda</h3></a></li>
            <li><a class="header_nav_link" href="#site"><h3>Sobre</h3></a></li>
        </ul>
    </header> -->
    <!-- FIM HEADER -->

    <!-- ########### CADASTRO INICIO ########### -->
    <div class="container-login">
        <div class="box">
            <div class="form-box">
                <ul class="tab-group">
                    <li class="tab1"><a href="../usuario/usuario.php" style="border-radius: 15px;margin-right:8x;">Usuário</a></li>
                    <li class="tab2"><a href="../jogador/jogador.php" style="border-radius: 15px;margin-left:8px;">Jogador</a></li>
                </ul>

                <h2>Criar Conta</h2>
                <p> Bem-vindo Jogador. Você já é membro? <a href="../login/login.php"> Login </a> </p>
                <form id="form" action="cadastro.php" method="post">
                    <div class="input-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite o seu nome completo" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite o seu email" required>
                    </div>

                    <div class="input-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="Digite o seu telefone" required>
                    </div>

                    <div class="input-group">
                        <label for="jogo">CPF</label>
                        <input type="Text" id="cpf" name="cpf" placeholder="DIgite seu CPF" required>
                    </div>

                    <div class="input-group">
                        <label for="elo">Qual seu Elo?</label>
                      <select class="select" id="elo" name="Elo">
                          <option value="Ouro-Esmeralda">Ouro-Esmeralda</option>
                          <option value="Diamante-Mestre">Diamante-Mestre</option>
                      </select>
                    </div>

                    <div class="input-group w50">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>

                    <div class="input-group w50">
                        <label for="Confirmarsenha">Confirmar Senha</label>
                        <input type="password" id="Confirmarsenha" name="Confirmarsenha" placeholder="Confirme a senha" required>
                    </div>

                    <div class="input-group">
                        <button>Cadastrar</button>
                    </div>
                    <span id="msg-error">
                        <?php
                            if (isset($_GET['error']))
                                echo $_GET['error'];
                        ?>
                    </span>
                    <p class="home-home"><a href="../paginahome/index.html">HOME</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- FIM CADASTRO -->



    <!-- FOOTER INICIO -->
    <!-- <footer id="final">
        <div class="container">
            <div class="footer-info">
                <p>TCC ETEC &copy; 2024 - Todos os direitos reservados</p>
                <ul>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Termos de Serviço</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <p>Siga-nos nas redes sociais:</p>
                <ul>
                    <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </footer> -->
    <!-- FIM FOOTER -->
</body>
</html>