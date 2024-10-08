<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../../css/footer-home.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

   
    <link rel="stylesheet" href="css/styles.css">
  </head>
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
  <body>
    <div class="container">
      <header>
  <nav class="header__nav">
    <ul class="header__nav__list">
      <li><a class="header__nav__link" href="../home.php"><h3>Home</h3></a></li>
      <li><a class="header__nav__link" href="index.php"><h3>Dashboard</h3></a></li>
      <li><a class="header__nav__link" href="../Ajuda/index.php"><h3>Ajuda</h3></a></li>
                </ul>

                <div class="dropdown">
<button class="dropbtn"><a class="header__nav__link perfil" href="#">
        <img width="32" height="32	" src="https://img.icons8.com/cotton/64/user-male-circle.png" alt="user-male-circle"/><?php echo $_SESSION['user_name']; ?>
      </a></button>
<div class="dropdown-content">
<a href="../perfil/index.php" >Perfil</a>
<a href="../logout.php">Sair</a>

</div>
</div>
</div>
    <div class="grid-container">

      <main class="main-container">

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <h3>Serviços Finalizados</h3>
              <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1>249</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>Serviços Pendentes</h3>
              <span class="material-icons-outlined">notification_important</span>
            </div>
            <h1>25</h1>
          </div>
      
          <div class="card">
            <div class="card-inner">
              <h3>CUSTOMERS</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <h1>1500</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>ALERTS</h3>
              <span class="material-icons-outlined">category</span>
            </div>
            <h1>56</h1>
          </div>

        </div>

        <div class="charts">

          <div class="charts-card">
            <h2 class="chart-title">Bruto Mensal(ano)</h2>
            <div id="bar-chart"></div>
          </div>

          <div class="charts-card">
            <h2 class="chart-title">Serviços finalizados (Ano)</h2>
            <div id="area-chart"></div>
          </div>

        </div>
      </main>
      <!-- End Main -->

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

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>