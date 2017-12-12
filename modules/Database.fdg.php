<?php
class FDG_Database {
  private $modVersion = "0.1a";
	public static function Connect($config) {
    return new mysqli($config["Host"], $config["Username"], base64_decode($config["Password"]), $config["Database"]); // open the MySQLi connection
	}

  public static function PConnect($config) {
    return new mysqli('p:'.$config["Host"], $config["Username"], base64_decode($config["Password"]), $config["Database"]); // open the MySQLi connection
	}

  public static function Close($conn){
    // close the connection and check if it was a success
    if($conn->close()){
      // if the connection has been closed
      return true; // return true
    }else{
      // if the connection hasn't been closed
      return false; // return true
    }
  }
}
