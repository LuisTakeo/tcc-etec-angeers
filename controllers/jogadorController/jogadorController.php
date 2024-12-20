<?php
namespace controllers\jogadorController;


use models\Jogador;
use repository\JogadorRepository;
use services\JogadorService;
use models\Contrato;
use services\ContratoService;
use controllers\contratoController\ContratoController;
use DateTime;
use PDO;
use PDOException;

class JogadorController
{
    private $db;
    private $jogadorService;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $jogadorRepository = new JogadorRepository($this->db);
        $this->jogadorService = new JogadorService($jogadorRepository);
    }

    public function create($new_jogador)
    {
        try
        {
            $message = $this->jogadorService->createJogador($new_jogador);
            echo $message;
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
    }

    public function cadastrarApi($new_jogador)
    {
        try
        {
            $message = $this->jogadorService->createJogador($new_jogador);
            echo json_encode(["message" => $message], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $err)
        {
            echo json_encode(['error' => $err->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getJogadorById($id)
    {
        try
        {
            $jogador = $this->jogadorService->getJogadorById($id);
            return $jogador;
        }
        catch (PDOException $err)
        {
            throw new PDOException("Jogador não encontrado");
        }
    }

    public function getJogadorByIdToApi($id)
    {
        try
        {
            $jogador = $this->jogadorService->getJogadorById($id);
            echo json_encode($jogador, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $err)
        {
            echo json_encode(['error' => $err->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getJogadorByEmailToApi($email)
    {
        try
        {
            $jogador = $this->jogadorService->getJogadorByEmail($email);
            echo json_encode($jogador->toArray(), JSON_UNESCAPED_UNICODE);

        } catch (PDOException $err)
        {
            echo json_encode(['error' => $err->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getJogadores()
    {
        try
        {
            $jogadores = $this->jogadorService->getJogadores();
            http_response_code(200);
            echo json_encode(["jogadores" => array_map(function ($jogador)
            {
                return $jogador->toArray();
            }, $jogadores), "total" => count($jogadores), "status" => "success"], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $err)
        {
            echo json_encode(['error' => $err->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    public function loginToApi($email, $senha)
    {

        $jogador = $this->jogadorService->loginJogador($email, $senha);
        http_response_code(200);
        echo json_encode(["jogador" => $jogador->toArray(), "status" => "success"], JSON_UNESCAPED_UNICODE);

    }

    public function loginJogador(string $email, string $senha)
    {
        $jogador = $this->jogadorService->loginJogador($email, $senha);
        session_start();
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
        $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

        $_SESSION['user_id'] = $jogador->getId();
        $_SESSION['user_name'] = $jogador->getName();
        $_SESSION['user_email'] = $jogador->getEmail();
        $_SESSION['type_login'] = "jogador";
    }

    public function showContratosPendentes(ContratoController $contratoController)
    {
        $contatosPendentes = $contratoController->getContratosPendentes();
        echo "<section class='main__servicos'>
            <div class='main__servicos__title'>
                    <h3>Serviços Pendentes</h3>
            </div>
            <div class='main__servicos__cards'>";
        $contratos_pendentes = array_filter($contatosPendentes, function($contrato) {
            return $contrato['statusContrato'] == 'pendente';
        });
        // var_dump($contratos_pendentes);
        foreach ($contratos_pendentes as $contrato)
        {
            if ($contrato['ds_statuscli'] != 'buscando')
            {
                continue;
            }
            // var_dump($contrato);
            echo "<div class='card'>";
            echo "<div class='card__description'>";
            echo "<h4 class='card__description__title'>" .
                ($contrato['cd_cli'] ? $contrato['name_cli'] : "Aguardando jogador") ."</h4>";
            echo "<p class='card__description__text'>". $contrato['nm_serv'] . " - " . showStatus($contrato['ds_statuscli']) . "</p>";
            echo "<img width='50' height='50' src='https://img.icons8.com/cotton/64/user-male-circle.png' alt='add--v1'/>";
            echo "<p class='card_description_text'>Inicio-" .
            DateTime::createFromFormat('Y-m-d H:i:s', $contrato['ds_data'])->format('d/m/Y')  .
            " </p>";
            // echo "<a class='card__link' href='#'>Detalhes</a>";
            echo "<a class='card__link' href='./contratoAtivo.php?pendente=1&contrato_id=".$contrato['cd_contrato']."'>Aceitar</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>
            </section>";
    }
    public function showContratos($id)
    {
        try
        {
            $contratos = new ContratoController($this->db);
            $contratosJogador = $contratos->getContratosByJogador($id);
            // $contatosPendentes = $contratos->getContratosPendentes();
            // var_dump($contratosJogador);
            echo "Contratos do jogador:<br>";
            var_dump($contratosJogador);
            return $contratos;
        } catch (PDOException $err)
        {
            echo $err->getMessage();
        }
        return NULL;
    }
}

// funções de jogador
function cadastrarJogador(PDO $connect, array $new_jogador)
{
    try
    {
        echo "Cadastrando jogador...<br>";
        $connect->beginTransaction(); // proteção para rollback
        if (!$new_jogador)
            throw new PDOException("Empty array");
        $sql = "INSERT INTO tb_jog_profis
            (name_jog, ds_senha, no_tel, ds_email, no_cpf, jogador_ativo, data_inclusao,
            data_exclusao, ds_rank)
            values
            (:name_jog, :ds_senha, :no_tel, :ds_email, :no_cpf, :jogador_ativo, :data_inclusao, :data_exclusao, :ds_rank)";
        $state = $connect->prepare($sql);
        $state->bindParam(':name_jog', $new_jogador["name"]);
        $state->bindParam(':ds_senha', $new_jogador["senha"]);
        $state->bindParam(':no_tel', $new_jogador["tel"]);
        $state->bindParam(':ds_email', $new_jogador["email"]);
        $state->bindParam(':no_cpf', $new_jogador["cpf"]);
        $state->bindParam(':jogador_ativo', $new_jogador["jogador_ativo"]);
        $state->bindParam(':data_inclusao', $new_jogador["data_inclusao"]);
        $state->bindParam(':data_exclusao', $new_jogador["data_exclusao"]);
        $state->bindParam(':ds_rank', $new_jogador["rank"]);
        $state->execute();
        $connect->commit(); // confirma a transação
        echo "New record created successfully";
    } catch (PDOException $err)
    {
        $connect->rollBack(); // desfaz a transação em caso de erro
        if ($err->getCode() == 23000)
            throw new PDOException("Jogador já cadastrado com este CPF ou e-mail");
        else
            throw new PDOException("Error: " . $err->getMessage());
    }
}

function getJogador(PDO $connect, int $id)
{
    try
    {
        $sql = "SELECT * FROM tb_jog_profis WHERE id_jogador = :id";
        $state = $connect->prepare($sql);
        $state->bindParam(':id', $id);
        $state->execute();
        $result = $state->fetch(PDO::FETCH_ASSOC);
        if (!$result)
            throw new PDOException("Jogador não encontrado");
        return $result;
    } catch (PDOException $err)
    {
        echo "Error: " . $err->getMessage();
    }
}

function getJogadorByEmail(PDO $connect, string $email)
{
    try
    {
        $sql = "SELECT * FROM tb_jog_profis WHERE ds_email = :email";
        $state = $connect->prepare($sql);
        $state->bindParam(':email', $email);
        $state->execute();
        if ($state->rowCount() == 0)
            throw new PDOException("Jogador não encontrado");
        $result = $state->fetch(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new PDOException("Jogador não encontrado");
        return $result;
    } catch (PDOException $err)
    {
        throw new PDOException("Error: " . $err->getMessage());

    }
}

function getJogadores(\PDO $connect)
{
    try
    {
        $sql = "SELECT cd_jog, name_jog, no_tel, ds_email, ds_rank FROM tb_jog_profis";
        $state = $connect->prepare($sql);
        $state->execute();
        $result = $state->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result)
            throw new PDOException("Nenhum jogador encontrado");
        return $result;
    } catch (PDOException $err)
    {
        echo "Error: " . $err->getMessage();
        return null;
    }
}