# HOTP/TOTP Token Generator

This is a simple PHP library and script that will generate HOTP and TOTP tokens. The library fully conforms to RFCs 4226 and 6238. All hashing algorithms are supported as well as the length of a token and the start time for TOTP.

## Installation (Direct usage! Checkout branch 'directUse')

```
wget -O Base32.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/src/Base32.php
wget -O Hotp.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/src/Hotp.php
wget -O Totp.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/src/Totp.php
```

**Examples:**

```
wget -O generate.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/generate.php
wget -O validate-demo.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/validate-demo.php
wget -O validate-demo-two-token.php https://raw.githubusercontent.com/user9209/php-totp/refs/heads/directUse/validate-demo-two-token.php
```

**Modify or delete `generate.php` and `validate-demo.php`**

To get a QR code for your secret you can use e.g. [Quick-and-Duty-Java-Code](https://github.com/user9209/quick-and-duty-totp-example).

*Done*

### Validate Demo Two Token

See `validate-demo-two-token.php`.

#### Automated Script with wget

```
TOKEN1=123456
TOKEN2=654321
wget -O install.sh https://www.example.com/ssh/?token1=$TOKEN1&token2=$TOKEN2

chmod 500 install.sh
./install.sh
```

#### Use a bot to get the vaild link

Use e.g. a matrix bot sending you the link with the valid token already set.  
Send a message to the bot, get as answer the link.


## Installation (Checkout branch 'master'!)

Add the following to your composer.json:

```
{
    "require": {
        "lfkeitel/phptotp": "^1.0"
    }
}
```

And run `composer install`.

## Usage

```php
<?php

use lfkeitel\phptotp\{Base32,Totp};

# Generate a new secret key
# Note: GenerateSecret returns a string of random bytes. It must be base32 encoded before displaying to the user. You should store the unencoded string for later use.
$secret = Totp::GenerateSecret(16);

# Display new key to user so they can enter it in Google Authenticator or Authy
echo Base32::encode($secret);

# Generate the current TOTP key
# Note: GenerateToken takes a base32 decoded string of bytes.
$key = (new Totp())->GenerateToken($secret);

# Check if user submitted correct key
if ($user_submitted_key !== $key) {
    exit();
}
```

## Documentation

### lfkeitel\phptotp\Totp extends Hotp

- `__construct($algo = 'sha1', $start = 0, $ti = 30): Totp`
    - `$algo`: Algorithm to use when generating token
    - `$start`: The beginning of time
    - `$ti`: Time interval between tokens
- `GenerateToken($key, $time = null, $length = 6): string`
    - `$key`: Secret key as bytes, base32 decoded
    - `$time`: Time to use for the token, defaults to now
    - `$length`: Length of token

### lfkeitel\phptotp\Hotp

- `__construct($algo = 'sha1'): Hotp`
    - `$algo`: Algorithm to use when generating token
- `GenerateToken($key, $count = 0, $length = 6): string`
    - `$key`: Secret key as bytes, base32 decoded
    - `$count`: HOTP counter
    - `$length`: Length of token
- `GenerateSecret($length = 16): string`
    - `$length`: Length of string in bytes
    - `Return`: This method returns a string of random bytes, use Base32::encode when displaying to the user.

### lfkeitel\phptotp\Base32

- `static encode($data): string`
    - `$data`: Data to base32 encode
- `static decode($data): string`
    - `$data`: Data to base32 decode

## generate.php

generate.php is a script that acts exactly like Google Authenticator. It takes a secret key, either as an argument or can be entered when prompted on standard input, and generates a token assuming SHA1, Unix timestamp for start, and 30 second time intervals. The secret key should be base32 encoded.

```php
$ ./generate.php
Enter secret key: turtles
Token: 338914
$
```

## License

This software is released under the MIT license which can be found in LICENSE.
