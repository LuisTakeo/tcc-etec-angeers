<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <?php

use controllers\contratoController\ContratoController;
use controllers\jogadorController\JogadorController;
use controllers\usuarioController\UsuarioController;

    use function Connection\connect_to_db_pdo;
    use function controllers\contratoController\getContratoById;
    include_once("./includes.php");

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
                    <img width="32" height="32	" src="https://img.icons8.com/cotton/64/user-male-circle.png" alt="user-male-circle"/>
                    <?php echo $_SESSION['user_name']; ?></a></button>

                    <div class="dropdown-content">
                        <a href="perfil/index.php" >Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>


            </nav>

        </header>
    </div>


    <div class="container main">

        <section class="main__perfil">
            <section>
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

                    echo "<h1 class='main__perfil__title'>Contrato</h1>";
                    echo "<p class'card__description__text'>Nome do Client: " . $cliente->getName() . "</p>";
                    if ($jogador)
                        echo "<p class'card__description__text'>Nome do Jogador: " . $jogador->getName() . "</p>";
                    else
                        echo "<p class'card__description__text'>Nome do Jogador: Não encontrado</p>";
                    echo "<p class'card__description__text'>Valor do contrato: " . $contrato->getValor() . "</p>";
                    echo "<p class'card__description__text'>Status do contrato: " . $contrato->getStatusContrato() . "</p>";
                    echo "<p class'card__description__text'>Data do contrato: " . $contrato->getDataInicio() . "</p>";
                }
                catch (\PDOException $e)
                {
                    echo $e->getMessage();
                }
                ?>
            </section>
        </section>
    </div>
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
</body>
</html>