<?php
    include("../connection/session_secure.php");
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['type_login'] == "usuario") {
            header("Location: ../home-usuario/home.php");
            exit();
        }
        if ($_SESSION['type_login'] == "jogador") {
            header("Location: ../home-jogador/home.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>login</title>
</head>
<body>
    <div class="background-image">
     <div class="main-login">
            <div class="left-login">
                <img src="gif-jett.gif" alt="">
            </div>

            <form class="card-login" action="login-script.php" method="post">
                <h1>LOGIN</h1>
                <h1>BEM VINDO DE VOLTA! </h1>
                <?php
                    if (isset($_GET['error']))
                    {
                        echo "<p class='error'>" . $_GET['error'] . "</p>";
                    }
                ?>
                <div class="textfield">
                <label for="typelogin">Tipo de Login</label>
                <select name="typelogin" id="" class="select">
                    <option value="jogador">Jogador</option>
                    <option value="usuario">Usuario</option>
                </select>
                </div>
                <div class="textfield">
                    <label for="usuario">Usúario</label>
                    <input type="text" name="usuario" placeholder="Usuario">
                </div>
                <div class="textfield">
                    <label for="Senha">Senha</label>
                    <input type="password" name="senha" placeholder="Senha">
                    <p class="criar-style">  <a href="../recuperaremail/email-recuperar-senha.html" class="criar-link"> <i>    Esqueceu sua senha?</i> </a></p>
                </div>
                <a href="../home-usuario/home.html"><button class="btn-login">LOGIN</button></a>
                <p class="criar-style">Se não tem uma conta  <a href="../usuario/usuario.php" class="criar-link"> <i >clique aqui </i> </a></p>
               <a href="../paginahome/index.html" class="home-style">  <p ><i>Home</i> </p> </a>

            </form>
        </div>



    </div>

</body>
</html>