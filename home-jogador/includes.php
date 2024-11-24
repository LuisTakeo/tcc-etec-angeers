<?php

include("../connection/session_secure.php");
include("../connection/connect.php");

include("../model/Usuario.php");
include("../repository/usuarioRepository.php");
include("../services/UsuarioService.php");
include("../controllers/usuarioController/usuarioController.php");

include("../model/Jogador.php");
include("../repository/jogadorRepository.php");
include("../services/JogadorService.php");
include("../controllers/jogadorController/jogadorController.php");

include("../controllers/contratoController/contratoController.php");
include("../repository/contratoRepository.php");
include("../services/ContratoService.php");
include("../model/Contrato.php");