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
        if($this->_getConfig()->isEnabled() && !$this->_getSession()->getGeoIp())
        {
            Mage::getSingleton('loewenstark_geoip/redirect')->run();
        }
    }

    /**
     * 
     * @return Mage_Core_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('core/session');
    }
}