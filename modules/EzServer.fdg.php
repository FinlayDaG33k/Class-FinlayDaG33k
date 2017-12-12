<?php
class FDG_EzServer {
	public static function jsLog($message) {
		echo "<script>console.log(\"".$message."\");</script>"; // return our console.log call
	}

	public static function getProto() {
		if(!empty($_SERVER['HTTPS'])){
      return "https";
    }else{
      return "http";
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
}
