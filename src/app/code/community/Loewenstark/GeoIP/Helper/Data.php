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
        return $this->_getIp();
    }

    /**
     * @see http://dev.maxmind.com/geoip/legacy/codes/iso3166/
     * 
     * @return string
     */
    public function getGeoCountry()
    {
        return geoip_country_code_by_name($this->_getIp());
    }
    
    /**
     * @see http://www.php.net/manual/en/function.geoip-continent-code-by-name.php
     * 
     * @return string
     */
    public function getGeoContinent()
    {
        return geoip_continent_code_by_name($this->_getIp());
    }
    
    /**
     * 
     * @return string
     */
    protected function _getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    
    /**
     * 
     * @return string get _SERVER['HTTP_ACCEPT_LANGUAGE']
     */
    public function getBrowserLanguage()
    {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
}