<?php

require '../env.php';


MercadoPago\SDK::setAccessToken(MERCADO_PAGO_ACCESS_TOKEN);

// // A partir daqui, você pode acessar as constantes
// echo "Access Token: " . MERCADO_PAGO_ACCESS_TOKEN . "\n";
// echo "Public Key: " . MERCADO_PAGO_PUBLIC_KEY . "\n";

// var_dump($_ENV);
