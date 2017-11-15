<?php
class FDG_Files{
  function sizeToBinary($bytes,$units){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log($chunkSize));
    $pow = min($pow, count($units) - 1);
    $precision = 2;
    $bytes /= pow($chunkSize, $pow);;
  }
  function sizeToSI($bytes,$units){
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log($chunkSize));
    $pow = min($pow, count($units) - 1);
    $precision = 2;
    $bytes /= pow($chunkSize, $pow);;
  }
}
