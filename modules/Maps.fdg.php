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
      if($units || $units = "imperial"){
        $units = "imperial";
      }else{
        $units = "metric";
      }
      return file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($origin)."&destinations=".urlencode($destination)."&region=".urlencode($region)."&mode=".urlencode($mode)."&units=".urlencode($units)."&key=".urlencode($key));
    }

    /**
    * request directions and launch Google Maps with the results
    *
    * @param
    */
  }
