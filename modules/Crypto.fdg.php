<?php
class FDG_Crypto {
  private $modVersion = "0.1a";
  
  public static function genIv($lenght = 16){
    return random_bytes($lenght);
  }

  public static function aesEncrypt($value,$key){
    $iv = self::genIv(16);
    return base64_encode($iv."***".openssl_encrypt($value, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv));
  }

  public static function aesDecrypt($data,$key){
    $data = explode("***",base64_decode($data));
    $iv = $data[0];
    $data = $data[1];
    return openssl_decrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
  }

}
