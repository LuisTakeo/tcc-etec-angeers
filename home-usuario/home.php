<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        .profile-pic {
            border-radius: 50%;
        }

    </style>
	<link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php

use function Connection\connect_to_db_pdo;
use function controllers\contratoController\getContratosByUsuario;

        include("./includes.php");
        if (!isset($_SESSION['user_id'])) {
            // Se não estiver logado, redireciona para a página de login
            header('Location: ../login/login.php');
            exit();
        }
        if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "jogador") {
            header("Location: ../home-jogador/home.php");
            exit();
        }
    ?>
    <div class="container">
        <header>
            <nav class="header__nav">
                <ul class="header__nav__list">
                    <li><a class="header__nav__link" href="./home.php"><h3>Home</h3></a></li>
                    <li><a class="header__nav__link" href="./Servicos/Servicos.php"><h3>Serviços</h3></a></li>
                    <li><a class="header__nav__link" href="./Ajuda/index.php"><h3>Ajuda</h3></a></li>
                </ul>

                <div class="dropdown">
                    <button class="dropbtn"><a class="header__nav__link perfil" href="#">
                    <img width="32" height="32"  class="profile-pic"
                                src="
                                <?php
                                if (file_exists("./uploads/" . $_SESSION['user_email'] . "/perfil.jpg"))
                                    echo "./uploads/" . $_SESSION['user_email'] . "/perfil.jpg";
                                else
                                    echo "https://img.icons8.com/cotton/64/user-male-circle.png";
                                ?>
                                " alt="user-male-circle"/>
                    <?php echo $_SESSION['user_name']; ?></a></button>

                    <div class="dropdown-content">
                        <a href="perfil/index.php" >Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>


            </nav>

        </header>
    </div>
    <main class="container main">
		<section class="main__perfil">
			<h2 class="main__perfil__title">
                <?php
                    echo "Bem-vindo, " . $_SESSION['user_name'];

                ?>
            </h2>
		</section>
        <?php
            include("./ContratosView.php");
        ?>
        <!-- <section class="main__servicos">
            <div class="main__servicos__title">
                <h3 >Serviços ativos</h3>
            </div>
            <div class="main__servicos__title">
                <h3>Finalizado</h3>
            </div>
            <div class="main__servicos__cards">
                <div class="card">
                    <div class="card__description">
                        <h4 class="card__description__title">Jogador Prof A</h4>
                        <p class="card__description__text">Duo Boost - Em andamento</p>
                    </div>
                    <a class="card__link" href="#">Delhes</a>
                </div>
                <div class="card">
                    <div class="card__description">
                        <h4 class="card__description__title">Jogador Prof B</h4>
                        <p class="card__description__text">Coach - Finalizado</p>
                    </div>
                    <a class="card__link" href="#">Detalhes</a>
                </div>
            </div>
        </section> -->
    </main>

    <footer id="final">
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
                    <li><a href="#" target="_blank"><i class="fab fa-facebook-f white"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-twitter white"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-instagram white"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-linkedin-in white"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-youtube white"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
        <script>
            const list = document.querySelector('.header__box__options');
            const perfilLink = document.querySelector('.perfil');
            perfilLink.addEventListener('click', () => {
                list.classList.toggle('active');
            });
        </script>
</body>
</html>