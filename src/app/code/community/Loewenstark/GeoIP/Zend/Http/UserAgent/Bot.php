<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Zend_Http_UserAgent_Bot
extends Zend_Http_UserAgent_Bot
{
    /**
     * Comparison of the UserAgent chain and browser signatures
     *
     * @param  string $userAgent User Agent chain
     * @param  array $server $_SERVER like param
     * @return bool
     */
    public static function match($userAgent, $server = null)
    {
        $_uaSignatures = array_unique(array_replace(self::$_uaSignatures, Mage::helper('loewenstark_geoip/config')->getUserAgents()));
        return self::_matchAgentAgainstSignatures($userAgent, $_uaSignatures);
    }
}