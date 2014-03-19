<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Helper_Log
extends Loewenstark_GeoIP_Helper_Abstract
{
    
    public function log($message)
    {
        Mage::log($message, null, 'geoip.log', $this->_getConfig()->isLogEnabled());
    }
}