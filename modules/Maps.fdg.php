<?php
  /**
  * Easily integrate Google Maps with your application
  */

  class FDG_Maps {
    public function __construct($fdg) {
      $this->FinlayDaG33k = $fdg;
    }

    /**
    * Get the distance between two locations (as the crow flies)
    *
    * @param string $origin The start location
    * @param string $destination The end location
    * @param string $region the ccTLD of the region you want to search in
    * @param string $mode The mode of traveling
    * @param int|string $units Switch between Metric and Imperial: 0 for Metric, 1 for Imperial (who uses Imperial anyways?)
    * @param string $key Optional API key for the Google Maps API
    * @return string the JSON response containing both the origin and destination locations and the distance
    */
    public function getDistance($origin,$destination,$region="",$mode="driving",$units=0,$key=""){
      if($units || strtolower($units) = "imperial"){
        $units = "imperial";
      }else{
        $units = "metric";
      }
      return file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($origin)."&destinations=".urlencode($destination)."&region=".urlencode($region)."&mode=".urlencode($mode)."&units=".urlencode($units)."&key=".urlencode($key));
    }

    /**
    * Display a map with the route between two locations
    *
    * @param string $origin The start locations
    * @param string $destination The end location
    * @param string $mode The mode of traveling
    * @param string $key Optional API key for the Google Maps api
    * @param int $height Optional height of the map
    * @param int $width Optional width of the map
    * @param bool $allowFullscreen Wether to allow fullscreen or not
    */
    public function showRoute($origin,$destination,$mode="driving",$key="",$height=600,$width=450,$allowFullscreen=true){
      ?>
        <iframe height="<?= htmlentities($height); ?>" width="<?= htmlentities($width); ?>" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=<?= urlencode($origin);?>&destination=<?= urlencode($destination);?>&mode=<?= urlencode($mode); ?>&key=<?= urlencode($key);?>" <?php if($allowfullscreen){echo "allowFullscreen";} ?>></iframe>
      <?php
    }
  }
