<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Helper_Config
extends Loewenstark_GeoIP_Helper_Abstract
{
    /**
     * Module is Enabled
     * 
     * @param string config path
     * @return bool
     */
    public function isEnabled($part = 'general')
    {
        if(!function_exists('geoip_country_code_by_name'))
        {
            return false;
        }
        switch($part)
        {
            case 'general':
            case 'storetolocalecountry':
            case 'storetocountry':
            case 'storetocontinent':
                $part = $part;
                break;
            default:
                $part = 'general';
        }
        if(!Mage::getStoreConfigFlag('loewenstarkgeoip/general/active'))
        {
            return false;
        }
        return Mage::getStoreConfigFlag('loewenstarkgeoip/'.$part.'/active');
    }
    
    /**
     * 
     * @return type
     */
    public function isLogEnabled()
    {
        return Mage::getStoreConfigFlag('loewenstarkgeoip/general/logactive');
    }
    
    /**
     * 
     * @return array
     */
    public function getUserAgents()
    {
        $data = @json_decode(Mage::getStoreConfig('loewenstarkgeoip/useragents/list'), true);
        if(!$data)
        {
            return array();
        }
        $ua = array();
        foreach($data as $value)
        {
           $ua[] = $value['ua'];
        }
        return $ua;
    }

    /**
     * get StoreView array key(id)=>value(code)
     * 
     * @return array
     */
    public function getStoreViews()
    {
        $cachetag = 'loewenstarkgeoip_storeviews';
        if(Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cachetag))
        {
            return unserialize($cache);
        }
        $options = array();
        foreach (Mage::app()->getWebsites() as $website)
        {
            foreach ($website->getGroups() as $group)
            {
                foreach ($group->getStores() as $store)
                {
                    $options[$store->getId()] = $store->getCode();
                }
            }
        }
        Mage::app()->saveCache(serialize($options), $cachetag, array('config'), false);
        return $options;
    }

    /**
     * 
     * @param int $store_id
     * @return string|boolean
     */
    public function getStoreViewCode($store_id)
    {
        foreach($this->getStoreViews() as $_id=>$_code)
        {
            if($_id == $store_id)
            {
                return $_code;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param string $code
     * @return string|boolean
     */
    public function getStoreViewId($code)
    {
        foreach($this->getStoreViews() as $_id=>$_code)
        {
            if($_code == $code)
            {
                return $_id;
            }
        }
        return false;
    }
    
    /**
     * get Current StoreView Code
     * @see self::getCurrentStoreViewCode
     * @return string
     */
    public function getCurrentStoreView()
    {
        return $this->getCurrentStoreViewCode();
    }
    
    /**
     * get Current StoreView Code
     * 
     * @return string
     */
    public function getCurrentStoreViewCode()
    {
        return Mage::app()->getStore()->getCode();
    }

    /**
     * 
     * @return array
     */
    public function getLocaleCountry()
    {
        return $this->_getJsonConfig('loewenstarkgeoip/storetolocalecountry/list');
    }

    /**
     * 
     * @return array
     */
    public function getCountry()
    {
        return $this->_getJsonConfig('loewenstarkgeoip/storetocountry/list');
    }

    /**
     * 
     * @return array
     */
    public function getContinent()
    {
        return $this->_getJsonConfig('loewenstarkgeoip/storetocontinent/list');
    }

    /**
     * 
     * @param string $path
     * @return array
     */
    protected function _getJsonConfig($path)
    {
        $data = @json_decode(Mage::getStoreConfig($path), true);
        if(!$data)
        {
            return array();
        }
        $result = array();
        foreach($data as $value)
        {
            $result[$value['store']] = $value['locale'];
        }
        return $result;
    }
    
    /**
     * prevent an endless loop
     * 
     * @return Loewenstark_GeoIP_Helper_Config
     */
    protected function _getConfig() {
        return $this;
    }
}