<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Helper_Data
extends Mage_Core_Helper_Abstract
{
    
    public function getIp()
    {
        if(isset($_SERVER['REMOTE_ADDR']))
        {
            return $_SERVER['REMOTE_ADDR'];
        }
        return false;
    }
    
    public function getGeoCountry()
    {
        $country = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
        if(empty($country))
        {
            $country = Mage::helper('loewenstark_geoip/config')->getDefaultCountry();
        }
        return $country;
    }
}