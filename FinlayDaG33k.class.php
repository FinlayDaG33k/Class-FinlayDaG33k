<?php
/*
 * Author: Aroop "FinlayDaG33k" Roelofs <me@finlaydag33k.nl>
 * License: FinlayDaG33k License (https://github.com/FinlayDaG33k/FinlayDaG33k-License/blob/master/LICENSE)
 *
 *
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

  /* We use this for loading the modules */
  public function LoadModules() {
    foreach (glob("$this->moduleDir/*.fdg.php") as $filename) {
      include $filename;
      $className = "FDG_" . str_replace(".fdg.php", "", basename($filename));
      $varName = str_replace("FDG_", "", $className);
      $this->Modules[$varName] = new $className();
    }
  }

  public function getPage(){
    if (!empty($_GET['page'])) { // Check if the user explicitly requested a page
    	$tmp_page = basename($_GET['page']); // Put the requested pagename into a little variable
    	if (file_exists("pages/{$tmp_page}.php")) { // Check if the page the user requested exists in out /pages directory
        // If the file exists
    		return $tmp_page; // return the tmp_page as the page
    	} else {
        // If the page does not exist
    		return "404"; // return the errorpage as the page
    	}
    }else{
      // If there has no page been explicitly requested by the user
      return "home"; // return the homepage as the page
    }
  }
}
