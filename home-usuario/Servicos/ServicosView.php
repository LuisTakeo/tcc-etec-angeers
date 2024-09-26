<?php
use function Connection\connect_to_db_pdo;
use function controllers\jogadorController\getJogadores;
use function controllers\servicosController\getServicos;
include("../../connection/connect.php");
include("../../controllers/jogadorController/jogadorController.php");
include("../../controllers/servicosController/servicosController.php");


try
{
	$connect = connect_to_db_pdo($server, $user, $password, $db);
	if (!$connect)
		throw new \PDOException("Connection failed");
	$servicos = getServicos($connect);
	if ($servicos) {
		foreach ($servicos as $servico) {
			echo "<div class='card'>";
			echo "<div class='card__description'>";
			echo "<h4 class='card__description__title'>" . $servico['nm_serv'] . "</h4>";
			echo "<p class='card__description__text'>" . $servico['ds_serv'] . "</p>";
			echo "</div>";
			echo "<a class='card__link' href='./NovoServico.php?tipo=" . $servico['nm_serv'] . "&id=" . $servico['cd_serv'] . "'>Contratar</a>";
			echo "</div>";
		}
	}
	$connect = null;
} catch (\PDOException $err)
{
	echo $err->getMessage();
	$connect = null;
}

?>
