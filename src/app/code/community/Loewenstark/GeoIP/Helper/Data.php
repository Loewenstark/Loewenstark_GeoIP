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
extends Loewenstark_GeoIP_Helper_Abstract
{

    const XML_PATH_MMDB = 'loewenstarkgeoip/general/mmdbpath';
    const XML_PATH_USE_GEOIP2 = 'loewenstarkgeoip/general/use_geoip2';
    
    protected $_geoIp2 = null;

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
        if (!function_exists('geoip_country_code_by_name') || $this->useGeoIp2Api())
        {
            if ($this->_getGeoIp2())
            {
                return $this->_getGeoIp2()->country->isoCode;
            }
            return false;
        }
        return geoip_country_code_by_name($this->_getIp());
    }

    /**
     * @see http://www.php.net/manual/en/function.geoip-continent-code-by-name.php
     * 
     * @return string
     */
    public function getGeoContinent()
    {
        if (!function_exists('geoip_continent_code_by_name') || $this->useGeoIp2Api())
        {
            if ($this->_getGeoIp2())
            {
                return $this->_getGeoIp2()->continent->code;
            }
            return false;
        }
        return geoip_continent_code_by_name($this->_getIp());
    }

    /**
     * 
     * @return string
     */
    protected function _getIp()
    {
        return '212.202.123.149'; //$_SERVER['REMOTE_ADDR'];
    }

    /**
     * 
     * @return string get _SERVER['HTTP_ACCEPT_LANGUAGE']
     */
    public function getBrowserLanguage()
    {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    /**
     * 
     * @return string
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * 
     * @return \GeoIp2\Model\Country
     */
    protected function _getGeoIp2()
    {
        if (is_null($this->_geoIp2))
        {
            try {
                $mmdb = Mage::getStoreConfig(self::XML_PATH_MMDB, 0);
                $reader = new GeoIp2\Database\Reader($mmdb);
                $this->_geoIp2 = $reader->country($this->_getIp());
            } catch (Exception $ex) {
                Mage::register(self::REGISTER_EXCEPTION, true, true);
                Mage::logException($ex);
                return false;
            }
        }
        return $this->_geoIp2;
    }

    /**
     * 
     * @return bool
     */
    protected function useGeoIp2Api()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_USE_GEOIP2, 0);
    }
}