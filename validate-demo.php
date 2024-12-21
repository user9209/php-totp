<?php
    /*
       Accepts the current token and the token before.
       Call: validate-demo.php?token=123456
     */
    require_once('Totp.php');
    require_once('Base32.php');

    if(isset($_GET['token'])) {
        $tokenUser = $_GET['token'];
        $secret = '77i65aj3zgxo3igxzq4fiurq65lq743o';
        $key = Base32::decode($secret);

        $token = (new Totp())->GenerateToken($key);

        $time = (new \DateTime())->getTimestamp() - 30;
        $tokenBefore = (new Totp())->GenerateToken($key, $time);

        if($tokenUser === $token || $tokenUser === $tokenBefore) {
            echo "[200] Token valid";
            http_response_code(200);
        }
        else {
            echo "[403] Forbitten access";
            http_response_code(403);
        }
    }
    else {
        echo "[400] Bad request";
        http_response_code(400);
    }
?>
