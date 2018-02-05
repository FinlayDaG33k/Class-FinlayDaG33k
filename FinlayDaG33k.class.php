<?php
/**
 * @author Aroop "FinlayDaG33k" Roelofs <me@finlaydag33k.nl>
 * @license FinlayDaG33k License (https://github.com/FinlayDaG33k/FinlayDaG33k-License/blob/master/LICENSE)
 * @example https://docs.finlaydag33k.nl/docs/Class-FinlayDaG33k The primary documentation
 */

/*
 * Special thanks to:
 * - Spike2147 (Helping me with a tonne of issues)
 */

class FinlayDaG33k {
  public $packageData = [];

  public $moduleDir = __DIR__ . "/modules/";
  public $Modules = [];
  public $fdgWarns = [];
  public function __construct() {
    // Load the packageData
    $this->packageData = json_decode(file_get_contents(__DIR__."/package.json"),1);

    // Check wether the current PHP version is higher or equal to the minimum
    if(version_compare(PHP_VERSION, $this->packageData['min-php']) < 0){
      array_push($this->fdgWarns,"We've detected that this server runs on PHP ".PHP_VERSION.". However, this library has been written for PHP >=".$this->packageData['min-php'].". Please consider updating your PHP! Failing to do so may result in nasty bugs!");
    }

    if($this->checkUpdate()){
      array_push($this->fdgWarns,"A New version for Class-FinlayDaG33k is available for download!");
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
        <script>console.warn("[Class-FinlayDaG33k] <?= $warn; ?>");</script>
      <?php
    }
  }

  public function checkUpdate(){;
    if (empty($this->packageData['version'])){
      return false;
    }
    $newData = json_decode(file_get_contents("https://raw.githubusercontent.com/FinlayDaG33k/Class-FinlayDaG33k/master/package.json"),1);
    if (empty($newData['version'])){
      return false;
    }

    if(version_compare($this->packageData['version'], $newData['version']) < 0){
      return true;
    }else{
      return false;
    }
  }

  public function checkDependencies(){
    foreach($this->packageData['dependencies'] as $dependency){
      if(!extension_loaded($dependency)){
        array_push($this->fdgWarns,"Missing dependency: " . $dependency . ". This library might not function as intended!");
      }
    }
  }
}

/**
* @var FinlayDaG33k an instance of the classloader
**/
$FinlayDaG33k = new FinlayDaG33k;
