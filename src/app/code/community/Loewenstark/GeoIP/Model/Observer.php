<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Model_Observer
{
    /**
     * 
     * @param type $event
     */
    public function redirectEvent($event)
    {
        if(!$this->_getConfig()->isEnabled())
        {
            $action = $event->getControllerAction();
            /* @var $action Mage_Core_Controller_Varien_Action */
            $path = trim($action->getRequest()->getPathInfo(), '/');
            
            echo '<pre>';
            var_dump($path,$this->_getLanguage()->getLanguages(), $this->_getLanguage()->getCurrentCountry(), $this->_getLanguage()->getCurrentContinent()); exit;
        }
        Mage::getSingleton('core/session')->setGeoIp(true);
    }

    /**
     * @return Loewenstark_GeoIP_Model_Language
     */
    protected function _getLanguage()
    {
        return Mage::getSingleton('loewenstark_geoip/language');
    }

    /**
     * 
     * @return Mage_Core_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('core/session');
    }

    /**
     * get StoreView Code
     * 
     * @return int
     */
    protected function _getStoreCode()
    {
        return Mage::app()->getStore()->getCode();
    }

    /**
     * get StoreViewId
     * 
     * @return int
     */
    protected function _getStoreId()
    {
        return Mage::app()->getStore()->getId();
    }

    /**
     * 
     * @return Loewenstark_GeoIP_Helper_Config
     */
    protected function _getConfig()
    {
        return Mage::helper('loewenstark_geoip/config');
    }

    /**
     * 
     * @return Loewenstark_GeoIP_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('loewenstark_geoip');
    }
    
    /**
     * 
     * @param string $url
     * @param array $params
     * @return string
     */
    protected function getUrl($url = '', $params = array())
    {
        return Mage::getUrl($url, $params);
    }
}