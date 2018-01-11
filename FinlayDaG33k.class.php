<?php
/**
 * @author Aroop "FinlayDaG33k" Roelofs <me@finlaydag33k.nl>
 * @license: FinlayDaG33k License (https://github.com/FinlayDaG33k/FinlayDaG33k-License/blob/master/LICENSE)
 */

/*
 * Special thanks to:
 * - Spike2147 (Helping me getting the module loading to work)
 */

class FinlayDaG33k {
  private $Version = "1.2a";
  public $moduleDir = __DIR__ . "/modules/";
  public $Modules = [];
  public function __construct() {
    $this->LoadModules();
  }

  function __get($name){
    if(isset($this->Modules[$name])){
      return $this->Modules[$name];
    }
  }

  /**
  * Load the modules
  */
  public function LoadModules() {
    foreach (glob("$this->moduleDir/*.fdg.php") as $filename) {
      include $filename;
      $className = "FDG_" . str_replace(".fdg.php", "", basename($filename));
      $varName = str_replace("FDG_", "", $className);
      $this->Modules[$varName] = new $className();
    }
  }
}

/**
* @return mixed an object for the class
*/
$FinlayDaG33k = new FinlayDaG33k;
