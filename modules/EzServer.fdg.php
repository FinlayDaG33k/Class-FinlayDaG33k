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
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    return self::getProto() . "://" . $_SERVER['HTTP_HOST'] . $uri_parts[0];
  }
}
