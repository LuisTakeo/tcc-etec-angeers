<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
	<link rel="stylesheet" href="./ajuda.css">
    <link rel="stylesheet" href="../../css/footer-home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php
        include_once("../../connection/session_secure.php");
        if (!isset($_SESSION['user_id'])) {
            // Se não estiver logado, redireciona para a página de login
            header('Location: ../../login/login.php');
            exit();
        }
        if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "usuario") {
            header("Location: ../../home-usuario/home.php");
            exit();
        }
    ?>
    <div class="container">
        <header class="header">
			<div class="header__top">
				<h1 class="header__title"><a href="../home.php"><img class="" src="../../logo.png" width="150" height="150" alt="" srcset=""></a></h1>
				<div class="header__box">
					<a class="header__nav__link perfil" href="../Perfil/index.php">
						<img width="32" height="32	" src="https://img.icons8.com/cotton/64/user-male-circle.png" alt="user-male-circle"/><?php echo $_SESSION['user_name']; ?>
					</a>
                    <ul class="header__box__options">
                        <li class="header__box__options__link"><a href="../Perfil/index.php" class="options__link">Perfil</a></li>
                        <li class="header__box__options__link"><a href="../logout.php"   class="options__link">Sair</a></li>
                    </ul>
				</div>
			</div>
			<nav class="header__nav">
				<ul class="header__nav__list">
					<li><a class="header__nav__link" href="../home.php"><h3>Home</h3></a></li>
					<li><a class="header__nav__link" href="../Servicos/Servicos.php"><h3>Serviços</h3></a></li>
					<li><a class="header__nav__link" href="../Ajuda/index.php"><h3>Ajuda</h3></a></li>
			</nav>
            <!-- Add your header content here -->
        </header>
    </div>

    <main class="container main">
		<section class="main__perfil">
			<h2 class="main__perfil__title">Bem vindo, <?php echo $_SESSION['user_name']; ?>!</h2>
		</section>
        <section class="main__servicos">
            <div class="main__servicos__title">
                <h3>Ajuda</h3>
            </div>
            <div class="main__servicos__help">
                <form class="form" action="#">
                    <div class="form__block">
                        <label class="form__label" for="name">Nome:</label>
                        <input class="form__input" type="text" id="name" name="name" placeholder="Insira seu nome" required>
                    </div>
                    <div class="form__block">
                        <label class="form__label" for="email">Email:</label>
                        <input class="form__input" type="email" id="email" name="email" placeholder="Insira seu e-mail" required>
                    </div>
                     <div class="form__block">
                         <label class="form__label" for="message">Mensagem:</label>
                         <textarea class="form__input form__textarea" id="message" name="message" placeholder="Nos conte sua dúvida" required></textarea>

                     </div>
                     <div class="form__block">

                         <button class="form__button" type="submit">Enviar</button>
                     </div>
                </form>

             </div>
            <!-- Add your profile information here -->
        </section>
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
        <script>
            const list = document.querySelector('.header__box__options');
            const perfilLink = document.querySelector('.perfil');
            perfilLink.addEventListener('click', () => {
                list.classList.toggle('active');
            });
        </script>
</body>
</html>