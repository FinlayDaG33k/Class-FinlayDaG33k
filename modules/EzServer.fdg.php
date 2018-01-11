<?php
/**
* A collection of handy functions for making your webdevelopment life easier
*/

class FDG_EzServer {
  const MOD_VERSION = "0.5.0.1a";

  public function __construct($fdg) {
    $this->FinlayDaG33k = $fdg;
  }

  /**
  * Simple Javascript console.log()
  *
  * @param string $message The message to be logged to the console
  */
	public function jsLog($message) {
		echo "<script>console.log(\"".$message."\");</script>";
	}

  /**
  * Get the protocol of the request
  * Compatible with Cloudflare since 0.4.1a
  *
  * @return string Wether using HTTP or HTTPS
  */
	public function getProto() {
    // Check wether is using Cloudflare or not
    if(!empty($_SERVER['HTTP_CF_VISITOR'])){
      return json_decode($_SERVER['HTTP_CF_VISITOR'],1)['scheme'];
    }else{
      if(!empty($_SERVER['HTTPS'])){
        return "https";
      }else{
        return "http";
      }
    }
	}

  /**
  * The method through which the request was send
  *
  * @return mixed The method
  */
  public function getMethod(){
    switch(strtoupper($_SERVER['REQUEST_METHOD'])){
      case "POST":
        return "POST";
        break;
      case "GET":
        return "GET";
        break;
    }
  }

  /**
  * @return string The home path of the current file
  */
  public function getHome(){
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    return rtrim(self::getProto()."://".$_SERVER['HTTP_HOST'].$pathInfo['dirname'],"/");
  }

  /**
  * @return string The root of the current domain
  */
  public function getRoot(){
    return self::getProto()."://".$_SERVER['HTTP_HOST'];
  }

  /**
  * Check wether the page the user requested exists
  *
  * @param string $pageDir The directory in which to check for pages
  * @param string $defaultPage The page to which to default when no page is specified
  * @param string $errorPage The page to show when the requested page does not exist
  * @return string The page to show the user
  */
  public function getPage($pageDir = "pages", $defaultPage = "home", $errorPage = "404"){
    if (!empty($_GET['page'])) { // Check if the user explicitly requested a page
    	$tmp_page = basename($_GET['page']); // Put the requested pagename into a little variable
    	if (file_exists("{$pageDir}/{$tmp_page}.php")) { // Check if the page the user requested exists in out /pages directory
        // If the file exists
    		return $tmp_page; // return the tmp_page as the page
    	} else {
        // If the page does not exist
    		return $errorPage; // return the errorpage as the page
    	}
    }else{
      // If there has no page been explicitly requested by the user
      return $defaultPage; // return the homepage as the page
    }
  }

  /**
  * Generate a pseudo-random string
  * Use with PHP >= 7.0.0 for a more cryptographically secure generator!
  *
  * @param int $lenght The lenght of the random string
  * @return string The random string
  */
  public function randomStr($length = 8){
    // Check if we run PHP7.0 or higher
    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
      // Use a more cryptographically secure generator
      return bin2hex(random_bytes($length));
    }else{
      // Not so cryptographically secure generator for older versions
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
  }
}
