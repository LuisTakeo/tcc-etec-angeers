<?php

require 'env.php';

use MercadoPago\SDK;
use MercadoPago\Payment;

SDK::setAccessToken(MERCADO_PAGO_ACCESS_TOKEN);

try {
    // Criação de uma preferência de pagamento
    $preference = new MercadoPago\Preference();

    // Configurando os itens para pagamento
    $item = new MercadoPago\Item();
    $item->title = 'Serviço contratado';
    $item->quantity = 1;
    $item->unit_price = 100.00; // Preço do serviço

    $preference->items = [$item];

    // Configuração dos dados do pagador (comprador de teste)
    $payer = new MercadoPago\Payer();
    $payer->email = 'test_user_1242486811@testuser.com'; // E-mail do comprador de teste
    $preference->payer = $payer;

    // Configuração de URLs de retorno
    $preference->back_urls = [
        "success" => "http://localhost/success.php", // URL de sucesso
        "failure" => "http://localhost/failure.php", // URL de falha
        "pending" => "http://localhost/pending.php"  // URL de pagamento pendente
    ];
    $preference->auto_return = "approved";

    // Salvar a preferência no Mercado Pago
    $preference->save();

    // Exibir o link do checkout
    echo "Link para pagamento: <a href='{$preference->init_point}'>Pagar agora</a>";
} catch (Exception $e) {
    echo "Ocorreu um erro: " . $e->getMessage();
}
