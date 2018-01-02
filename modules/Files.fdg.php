<?php
class FDG_Files{
  private $modVersion = "0.1.1a";
  public static function sizeToBinary($bytes,$units,$precision = 2){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
  public static function sizeToSI($bytes,$units,$precision = 2){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1000, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
}
