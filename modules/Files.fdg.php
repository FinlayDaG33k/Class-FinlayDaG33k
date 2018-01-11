<?php
/**
* Handy functions for file-related stuff
*/

class FDG_Files{
  private $modVersion = "0.1.1.1a";

  /**
  * Convert bytecount to a more human-readable format.
  *
  * @param int $bytes The bytes to convert
  * @param array $units An array of string objects, containing the display values
  * @return string The human-readable format
  */
  public static function sizeToBinary($bytes,$units,$precision = 2){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }

  /**
  * Convert bytecount to a more human-readable format.
  *
  * @param int $bytes The bytes to convert
  * @param array $units An array of string objects, containing the display values
  * @return string The human-readable format
  */
  public static function sizeToSI($bytes,$units,$precision = 2){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1000, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
}
