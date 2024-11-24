<?php
use controllers\contratoController\ContratoController;
use controllers\jogadorController\JogadorController;
use controllers\usuarioController\UsuarioController;
use function Connection\connect_to_db_pdo;

include_once("./includes.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
	<link rel="stylesheet" href="style.css">
    <link real="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .contract-details {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .contract-details h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .contract-details p {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }
        .contract-details a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .contract-details a:hover {
            background-color: #0056b3;
        }
        .profile-pic {
            border-radius: 50%;
        }
        .dropdown-content a {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php
        include_once("../connection/session_secure.php");
        if (!isset($_SESSION['user_id'])) {
            // Se não estiver logado, redireciona para a página de login
            header('Location: ../login/login.php');
            exit();
        }
        if (isset($_SESSION['type_login']) && $_SESSION['type_login'] == "usuario") {
            header("Location: ../home-usuario/home.php");
            exit();
        }
    ?>
    <div class="container">
          <header>
			<nav class="header__nav">
				<ul class="header__nav__list">
					<li><a class="header__nav__link" href="home.php"><h3>Home</h3></a></li>
					<li><a class="header__nav__link" href="Dashboard/index.php"><h3>Dashboard</h3></a></li>
					<li><a class="header__nav__link" href="Ajuda/index.php"><h3>Ajuda</h3></a></li>
                    </ul>

                    <div class="dropdown">
  <button class="dropbtn"><a class="header__nav__link perfil" href="#">
  <img width="32" height="32" style="border-radius: 50%;" class="profile-pic"
                                src="
                                <?php
                                if (file_exists("./uploads/" . $_SESSION['user_email'] . "/perfil.jpg"))
                                    echo "./uploads/" . $_SESSION['user_email'] . "/perfil.jpg";
                                else
                                    echo "https://img.icons8.com/cotton/64/user-male-circle.png";
                                ?>
                                " alt="user-male-circle"/>
                                <?php echo $_SESSION['user_name']; ?>
					</a></button>
  <div class="dropdown-content">
    <a href="perfil/index.php" >Perfil</a>
    <a href="logout.php">Sair</a>
  </div>
    </div>
</div>

    <main class="container main">
		<section class="main__perfil">
			<h2 class="main__perfil__title">
                <?php
                    echo "Bem-vindo, " . $_SESSION['user_name'];

                ?>
            </h2>
		</section>
        <section class="main__perfil">
            <section class="contract-details">
                <?php
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                try
                {
                    $connect = connect_to_db_pdo($server, $user, $password, $db);
                    if (!$connect)
                        throw new \PDOException("Connection failed");

                    $contratoController = new ContratoController($connect);
                    $contrato = $contratoController->getContrato($id);
                    $cliente = NULL;
                    $jogador = NULL;
                    // var_dump($contrato);
                    if ($contrato->getIdCliente())
                    {
                        $clienteController = new UsuarioController($connect);
                        $cliente = $clienteController->getClienteById($contrato->getIdCliente());
                    }
                    if ($contrato->getIdJogador())
                    {
                        $jogadorController = new JogadorController($connect);
                        $jogador = $jogadorController->getJogadorById($contrato->getIdJogador());
                    }

                    echo "<h1>Contrato</h1>";
                    echo "<img width='50' height='50' class='img-rounded' style='border-radius:50%' src='";
            if (file_exists("../home-usuario/uploads/" . $cliente->getEmail() . "/perfil.jpg")) {
                echo "../home-usuario/uploads/" . $cliente->getEmail() . "/perfil.jpg";
            } else
                echo "https://img.icons8.com/cotton/64/user-male-circle.png";
            echo "' alt='add--v1'/>";
                    echo "<p>Nome do Cliente: " . $cliente->getName() . "</p>";
                    if ($jogador)
                        echo "<p>Nome do Jogador: " . $jogador->getName() . "</p>";
                    else
                        echo "<p>Nome do Jogador: Não encontrado</p>";
                    echo "<p>Valor do contrato: " . $contrato->getValor() . "</p>";
                    echo "<p>Status do contrato: " . $contrato->getStatusContrato() . "</p>";
                    echo "<p>Data do contrato: " . $contrato->getDataInicio() . "</p>";
                    echo "<a href='./finalizar.php?idContrato=".$contrato->getId()."'>Finalizar</a>";
                }
                catch (\PDOException $e)
                {
                    echo $e->getMessage();
                }
                ?>
            </section>
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