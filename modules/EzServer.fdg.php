<?php
/**
* A collection of handy functions for making your webdevelopment life easier
*/

class FDG_EzServer {
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
  public function getPage($pageVar = "page", $pageDir = "pages", $defaultPage = "home", $errorPage = "404"){
    if (!empty($_GET[$pageVar])) { // Check if the user explicitly requested a page
    	$tmp_page = basename($_GET[$pageVar]); // Put the requested pagename into a little variable
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
  * @param int $length The length of the random string
  * @return string The random string
  */
  public function randomStr($length = 8){
    // Check if we run PHP7.0 or higher
    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
      // Use the random_bytes(), it should know what's best for us
      $bytes = random_bytes($length / 2); // Generate random bytes
    }else{
      // check whether /dev/urandom exists and is readable
      if(!ini_get('open_basedir') && is_readable('/dev/urandom')){
        // /dev/urandom exists and is readable!
        $fp = fopen('/dev/urandom', 'rb'); // open /dev/urandom
        $bytes .= @fread($fp, $length / 2); // get zeh bytes
      }else{
        // Use a non-cryptographically secure random string as final-resort
        array_push($this->fdgWarns,"Could not use random_bytes() nor /dev/urandom to create a random string! Using a non-cryptographically secure algorithm instead!");
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
      }
    }
    $result = '';
    // Split the string of random bytes into individual characters
    foreach (str_split($bytes) as $byte) {
      $result .= $chars[ord($byte) % $count];
    }
    return $result;
  }

  /**
  * Insert a string inside another string
  *
  * @param string $insert What to insert
  * @param int $pos the position where to insert
  * @param string $string The starting string
  * @return string The resulting string
  */
  public function strInsert($insert, $pos, $string){
    return substr($string, 0, $pos) . $insert . substr($string,0, $pos + strlen($insert));
  }

  /**
  * Check a misspelled word for the closest suggestion
  *
  * @param string $input The input word
  * @param array $wordlist An array containing all words to check the $input against
  * @return array An array containing the closest word and their distance
  */
  public function levenshtein($input,$words){
    $shortest = -1;
    foreach ($words as $word) {
      // calculate the distance between the input word and the current word
      $lev = levenshtein($input, $word);

      // check for an exact match
      if ($lev == 0) {
        // closest word is this one (exact match!)
        $closest = $word;
        $shortest = 0;
        // We've found an exact match, break the loop
        break;
      }

      // if this distance is less than the next found shortest distance, OR if a next shortest word has not yet been found
      if ($lev <= $shortest || $shortest < 0) {
        // set the closest match and shortest distance
        $closest  = $word;
        $shortest = $lev;
      }
    }

    // give the output to back
    return array("closest" => $closest, "distance" => $shortest);
  }

  /**
  * Get the visitor IP (Cloudflare compatible)
  *
  * @param bool $overwriteGlobal wether to overwrite the $_SERVER['REMOTE_ADDR'] global on detection of Cloudflare
  * @return string The visitor IP
  */
  public function getVisitorIP($overwriteGlobal = false){
    if(!empty($_SERVER['HTTP_CF_CONNECTING_IP'])){
      if($overwriteGlobal){
        $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
      }
      return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }else{
      return $_SERVER["REMOTE_ADDR"];
    }
  }
}
