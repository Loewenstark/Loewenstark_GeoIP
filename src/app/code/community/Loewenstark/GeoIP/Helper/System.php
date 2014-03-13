<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Helper_System
extends Mage_Core_Helper_Abstract
{
    
    public function getContientComment()
    {
        return $this->__('Examples: NA, EU, SA<br /><a target="_blank" href="http://www.php.net/manual/en/function.geoip-continent-code-by-name.php">Continent Codes</a>');
    }
}