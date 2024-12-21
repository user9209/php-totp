#!/usr/bin/php
<?php
/*
 * Usage: generate.php [key]
 *
 * If no key is provided as an arg, the script will ask for it.
 *
 */

require_once('Totp.php');
require_once('Base32.php');

$key = '';

if ($argc == 2) {
    $key = $argv[1];
} else {
    echo "Enter secret key: ";
    $key = trim(fgets(STDIN));

    if ($key == '') {
        $bytes = openssl_random_pseudo_bytes($i, $cstrong);
        $key   = Base32::encode($bytes);
        echo "The new key is: ".$key."\n";
    }
}

$key = Base32::decode($key);

echo "Token: " . (new Totp())->GenerateToken($key) . "\n";
