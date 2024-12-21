<?php
    // two token to avoid bruteForce: 10^12 = ~ 40 bit
    // simpler use TOTP App two times than e.g. modified TOTP with 12 chars
    // call: validate-demo-two-token.php?token1=123456&token2=654321

    require_once('.Totp.php');
    require_once('.Base32.php');

    if(isset($_GET['token1']) && isset($_GET['token2'])) {
        $tokenUser1 = $_GET['token1'];
        $tokenUser2 = $_GET['token2'];
        $secret1 = '77i65aj3zgxo3igxzq4fiurq65lq743o';
        $secret2 = 'x6yt63nup3mipc3x2kmvn5jnksybhszw';
        $key1 = Base32::decode($secret1);
        $key2 = Base32::decode($secret2);

        $token1 = (new Totp())->GenerateToken($key1);
        $token2 = (new Totp())->GenerateToken($key2);

        $time = (new \DateTime())->getTimestamp() - 30;
        $tokenBefore1 = (new Totp())->GenerateToken($key1, $time);
        $tokenBefore2 = (new Totp())->GenerateToken($key2, $time);

        if(($tokenUser1 === $token1 || $tokenUser1 === $tokenBefore1) &&
            ($tokenUser2 === $token2 || $tokenUser2 === $tokenBefore2)) {

            if ( file_exists(".script.sh") ) {
               header('Content-type: text/x-shellscript');
               header('Content-Disposition: attachment; filename="script.sh"');
               readfile(".script.sh");
            } else {
               http_response_code(404);
               die("[404] File not ready!");
            }
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
