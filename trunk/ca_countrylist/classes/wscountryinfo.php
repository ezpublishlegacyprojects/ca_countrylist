<?php

class wsCountryInfo {
  
  public function wsCountryInfo()
  {
    
  }
  
  static function getCountryList()
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ws.geonames.org/countryInfoJSON?style=full");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    // convert results in JSON
    $obj = json_decode($result);
    
    return $obj->{'geonames'};
  }
}