<?php
/**
* Make encrypting stuff easier!
*/

class FDG_Crypto {
  const MOD_VERSION = "0.1.0.1a";

  public function __construct($fdg) {
    $this->FinlayDaG33k = $fdg;
  }

  /**
  * Generate an IV (Initialization Vector) for use with AES (and other cyphers that use an IV)
  * Use bin2hex() to convert them to ASCII if so desired
  *
  * @param int $lenght The lenght of the IV
  * @return string The pseudo-randomly generated IV in the form of bytes.
  */
  public function genIv($lenght = 16){
    return random_bytes($lenght);
  }

  /**
  * Encrypt a value with the AES-256-CBC cypher
  * Will automatically get the IV from self::genIv
  *
  * @param string $value The value to be encrypted
  * @param string $key The key with which to encrypt $value
  */
  public function aesEncrypt($value,$key){
    $iv = self::genIv(16);
    return base64_encode($iv."***".openssl_encrypt($value, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv));
  }

  /**
  * Decrypt an AES-256-CBC cypher using a specified key.
  * The base64-decoded string has to be in the format: <IV>***<encrypted data>
  *
  * @param string $data A base64-encoded string containing the IV and the actual encrypted data
  * @param string $key The key needed to decypher the encrypted data
  * @return string The decrypted data
  */
  public function aesDecrypt($data,$key){
    $data = explode("***",base64_decode($data));
    $iv = $data[0];
    $data = $data[1];
    return openssl_decrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
  }

  /**
  * Generate a pseudo-random string for use with self::aesEncrypt
  *
  * @param string $a Some input
  * @param string $a Some other input
  * @param string|int $seed The main seed for the generator
  * @param string|int $seed2 A fixed secondary seed for the generator (Only change this when needed!).
  * @return string A 256-bit pseudo-random string
  */
  public function generateKey($a = "", $b = "", $seed, $seed2 = "L@m3s33ds@r3l@m3") {
    $str = $seed2;
    $str = $this->FinlayDaG33k->EzServer->strInsert($a, 0, $str);
    $str = $this->FinlayDaG33k->EzServer->strInsert($b, strlen($a), $str);
    srand($seed);
    $str = str_shuffle($str);
    srand(time()); // Set the seed back to time() to not interfere with other random generators
    return hash('sha256',$str);
  }
}
