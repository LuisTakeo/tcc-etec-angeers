
<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../header.css">
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
    <div class="container-header">
        <header class="header">
			<div class="header__top">
				<h1 class="header__title"><a href="../home.php"><strong><img class="" src="../../logo.png" width="150" height="150" alt="" srcset=""</a></h1>
				<div class="header__box">
					<a class="header__nav__link perfil" href="#">
						<img width="32" height="32	" src="https://img.icons8.com/cotton/64/user-male-circle.png" alt="user-male-circle"/><?php echo $_SESSION['user_name']; ?>
					</a>
                    <ul class="header__box__options">
                        <li class="header__box__options__link"><a href="./index.php" class="options__link">Perfil</a></li>
                        <li class="header__box__options__link"><a href="../logout.php"  class="options__link">Sair</a></li>
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


    <div class="container light-style flex-grow-1 container-p-y">
        <!-- <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4> -->
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">Geral</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Alterar Senha</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Aparencia</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">Redes sociais</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-connections">Conexões</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-notifications">Notificações</a>
                            <hr>

                    </div>
                    <a class="btn-logout"
                    href="#account-notifications">Log out</a>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt
                                    class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;
                                    <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['user_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="Andreas Sampaio Ferreira de Sousa">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" value="Andreassam009@gmail.com">
                                    <div class="alert alert-warning mt-3">
                                       Adicione seu telefone e ative a verificação em duas etapas.<br>
                                        <a href="javascript:void(0)">Cadastrar</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jogo</label>
                                    <select class="custom-select">
                                        <option>Valorant</option>
                                        <option selected>League of Legends</option>
                                        <option selected>Valorant & League of Legends</option>
                                    </select>
                                    <div class="Explicação">
                                        Isso nos ajuda a recomendar melhor nossas ofertas.<br>
                                     </div>
                                </div>
                                <br> <hr>
                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary">Salvar</button>&nbsp;
                                    <button type="button" class="btn btn-default">Cancelar</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Senha atual</label>
                                    <input type="password" class="form-control">
                                    <div class="Alerta">
                                        É necessario saber sua senha atual para trocar-lá.<br>
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">nova senha</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirme sua nova senha</label>
                                    <input type="password" class="form-control">
                                </div>
                                <br> <hr>
                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                                <br>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <textarea class="form-control"
                                        rows="5"> Olá meu nome é Andreas, sou um jogador de Valorant que estou preso no imortal3 a 2 anos.</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Data de nascimento</label>
                                    <input type="date" class="form-control" value="10-03-2007">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Região</label>
                                    <select class="custom-select">
                                        <option>América</option>
                                        <option selected>Europa</option>
                                        <option>África</option>
                                        <option>Ásia</option>
                                        <option>Oceania</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Informações de contato</h6>
                                <div class="form-group">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control" value="+555 11-94210-4940">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" value="Andreassam009@gmail.com">
                                </div>
                                <br> <hr>
                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" value="https://twitter.com/user">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" value="https://www.facebook.com/user">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Google+</label>
                                    <input type="text" class="form-control" value>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control" value>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" value="https://www.instagram.com/user">
                                </div>
                                <br> <hr>
                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-connections">
                            <hr class="border-light m-0">
                            <div class="conexoes">
                                <h5 class="btn-conexoes">
                          <i >  Sua conta google está conectada</i>
                                    </h5>
                                    <a href="javascript:void(0)" class="remover"><i> Remover</i></a>
                            </div>
                            <hr class="border-light m-0">
                            <hr>
                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <hr>
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                                    <br> <hr>
                                    <div class="text-right mt-3">
                                        <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                                        <button type="button" class="btn btn-default">Cancel</button>
                                    </div>
                                    <br>  <br>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Activity</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone comments on my article</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone answers on my forum
                                            thread</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone follows me</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Application</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">News and announcements</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly product updates</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly blog digest</span>
                                    </label>
                                    <br> <hr>
                                       <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="button" class="btn btn-default">Cancel</button>
        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
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
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>