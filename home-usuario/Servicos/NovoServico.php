<?php
use controllers\jogadorController\JogadorController;
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadores;
include_once("./includes.php");
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: ../../login/login.php');
    exit();
}
if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "jogador") {
    header("Location: ../../home-jogador/home.php");
    exit();
}
// $tipo_servico;
$id_servico;
if (isset($_GET['tipo']))
    $tipo_servico = $_GET['tipo'];
if (isset($_GET['idservico']))
    $id_servico = $_GET['idservico'];
// var_dump($id_servico);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
	<link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../../css/footer-home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
          <header>
			<nav class="header__nav">
				<ul class="header__nav__list">
					<li><a class="header__nav__link" href="../home.php"><h3>Home</h3></a></li>
					<li><a class="header__nav__link" href="./Servicos.php"><h3>Serviços</h3></a></li>
					<li><a class="header__nav__link" href="../Ajuda/index.php"><h3>Ajuda</h3></a></li>
                    </ul>

                    <div class="dropdown">
  <button class="dropbtn"><a class="header__nav__link perfil" href="#">
						<img width="32" height="32	" src="https://img.icons8.com/cotton/64/user-male-circle.png" alt="user-male-circle"/><?php echo $_SESSION['user_name']; ?>
					</a></button>
  <div class="dropdown-content">
    <a href="../Perfil/index.php" >Perfil</a>
    <a href="../logout.php">Sair</a>
  </div>
    </div>
</div>

    <main class="container main">
		<section class="main__perfil">
			<h2 class="main__perfil__title">Bem vindo, <?php echo $_SESSION['user_name']; ?>!</h2>
		</section>
        <section class="main__servicos">
            <div class="main__servicos__cards">
                <div class="card">
                    <div class="card__description">
                        <h4 class="card__description__title">Criar novo serviço de <?=$tipo_servico?></h4>
                        <p class="card__description__text"></p>
                    </div>
                    <a class="card__link" href="./Contratar.php?tipo=<?=$tipo_servico?>&idServico=<?=$id_servico?>&escolherJogador=0">Contratar</a>
                </div>
            </div>
        </section>

        <?php


        try {
            $connect = connect_to_db_pdo($server, $user, $password, $db);
            if (!$connect)
                throw new \PDOException("Connection failed");
            $jogadorController = new JogadorController($connect);
            $jogadores = getJogadores($connect);
            if ($jogadores) {
                echo "<section class='main__servicos'>";
                echo "<div class='main__servicos__title'>";
                echo "<h3>Jogadores disponíveis</h3>";
                echo "</div>";
                echo "<div class='main__servicos__cards'>";
                foreach ($jogadores as $jogador) {
                    echo "<div class='card'>";
                    echo "<div class='card__description'>";
                    echo "<h4 class='card__description__title'>" . $jogador['name_jog'] . ' - ' . $jogador['ds_email'] . "</h4>";
                    echo "<p class='card__description__text'>" . $jogador['ds_rank'] . "</p>";
                    echo "</div>";
                    echo "<a class='card__link' href='./Contratar.php?tipo=$tipo_servico&idServico=$id_servico&escolherJogador=1&idJogador=".$jogador['cd_jog']."'>Contratar</a>";
                    echo "</div>";
                }
                echo "</section>";
            }
        } catch (\PDOException $err) {
            echo "Error: " . $err->getMessage();
        }
        ?>
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