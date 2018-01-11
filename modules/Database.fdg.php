<?php
/**
* Easy to use MySQLi starter
*/

class FDG_Database {
  private $modVersion = "0.1.0.1a";

  /**
  * Start a MySQLi connection to a MySQL Database
  *
  * @param array $config an array containing all the credentials needed to connect
  * @param mixed The MySQLi connection
  */
	public static function Connect($config) {
    return new mysqli($config["Host"], $config["Username"], base64_decode($config["Password"]), $config["Database"]);
	}

  /**
  * Start a persistent MySQLi connection to a MySQL Database
  *
  * @param array $config an array containing all the credentials needed to connect
  * @param mixed The MySQLi connection
  */
  public static function PConnect($config) {
    return new mysqli('p:'.$config["Host"], $config["Username"], base64_decode($config["Password"]), $config["Database"]);
	}

  /**
  * Close a MySQLi connection
  *
  * @param mixed $conn The MySQLi connection to be closed
  * @return bool Wether closing the MySQLi connection succeeded or not
  */
  public static function Close($conn){
    if($conn->close()){
      return true;
    }else{
      return false;
    }
  }
}
