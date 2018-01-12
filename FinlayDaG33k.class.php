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
  public $packageData = json_decode(file_get_contents(__DIR__."/package.json"),1);

  public $moduleDir = __DIR__ . "/modules/";
  public $Modules = [];
  public function __construct() {
    // Check wether the current PHP version is higher or equal to the minimum
    if(version_compare(PHP_VERSION, $this->packageData['min-php']) < 0){
      array_push($this->fdgWarns,"We've detected that this server runs on PHP ".PHP_VERSION.". However, this library has been written for PHP >=".PACKAGEDATA['min-php'].". Please consider updating your PHP! Failing to do so may result in nasty bugs!");
    }

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

  /**
  * Write all loading warnings to the Javascript console
  */
  public function ShowWarnings(){
    foreach($this->fdgWarns as $warn){
      ?>
        <script>console.log("[Class-FinlayDaG33k] <?= $warn; ?>");</script>
      <?php
    }
  }
}

/**
* @var FinlayDaG33k an instance of the classloader
**/
$FinlayDaG33k = new FinlayDaG33k;
