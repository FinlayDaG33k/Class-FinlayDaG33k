<?php
class FDG_EzServer {
  private $modVersion = "0.4.1a";
	public static function jsLog($message) {
		echo "<script>console.log(\"".$message."\");</script>"; // return our console.log call
	}

	public static function getProto() {
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

  public static function getMethod(){
    switch(strtoupper($_SERVER['REQUEST_METHOD'])){
      case "POST":
        return "POST";
        break;
      case "GET":
        return "GET";
        break;
    }
  }

  public static function getHome(){
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    return self::getProto()."://".$_SERVER['HTTP_HOST'].$pathInfo['dirname'];
  }

  public static function getRoot(){
    return self::getProto()."://".$_SERVER['HTTP_HOST'];
  }

  public static function getPage(){
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
  public static function randomStr($length = 8){
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
