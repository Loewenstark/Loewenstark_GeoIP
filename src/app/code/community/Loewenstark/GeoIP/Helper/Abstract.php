<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
abstract class Loewenstark_GeoIP_Helper_Abstract
extends Mage_Core_Helper_Abstract
{

    const REGISTER_EXCEPTION = 'loegeoip_exception';

    public function __construct()
    {
        Mage::dispatchEvent('loewenstark_geoip_helper_abstract', array(
            'helper' => $this
        ));
        $helpername = strtolower(get_class($this)); // like loewenstark_geoip_helper_data / loewenstark_geoip_helper_config
        Mage::dispatchEvent($helpername, array(
            'helper' => $this
        ));
    }

    /**
     * 
     * @param string $message
     */
    public function log($message)
    {
        Mage::helper('loewenstark_geoip/log')->log($message);
    }

    /**
     * 
     * system configuration
     * 
     * @return Loewenstark_GeoIP_Helper_Config
     */
    protected function _getConfig()
    {
        return Mage::helper('loewenstark_geoip/config');
    }
}