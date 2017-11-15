<?php
class FDG_Database {
	public static function Connect($config) {
    return mysqli_connect($config["Host"], $config["Username"], base64_decode($config["Password"]), $config["Database"]); // open the MySQLi connection
	}

  public static function Close($conn){
    // close the connection and check if it was a success
    if(mysqli_close($conn)){
      // if the connection has been closed
      return true; // return true
    }else{
      // if the connection hasn't been closed
      return false; // return true
    }
  }
}
