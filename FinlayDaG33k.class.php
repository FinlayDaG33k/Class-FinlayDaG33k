<?php
/**
 * @author Aroop "FinlayDaG33k" Roelofs <me@finlaydag33k.nl>
 * @license FinlayDaG33k License (https://github.com/FinlayDaG33k/FinlayDaG33k-License/blob/master/LICENSE)
 */

/*
 * Special thanks to:
 * - Spike2147 (Helping me with a tonne of issues)
 */

class FinlayDaG33k {
  const VERSION = "2.0a";

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
      $this->Modules[$varName] = new $className($this);
    }
  }
}

/**
* @var FinlayDaG33k an instance of the classloader
**/
$FinlayDaG33k = new FinlayDaG33k;
