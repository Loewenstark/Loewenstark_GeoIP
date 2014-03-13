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
extends Mage_Core_Helper_Abstract
{
    public function isEnabled()
    {
        return Mage::getStoreConfig('geoip/general/active');
    }
    
    /**
     * @todo define in backend 
     * @return type
     */
    public function getLanguages()
    {
        return array('de','fr','en','nl');
    }
    
    /**
     * @todo add backend config, normaly safe only the storeview id, in this script we will create an mapping
     * 
     * @return type
     */
    public function getStoreViewLanguages()
    {
        return array(
            'de' => 'default',
            'de-AT' => 'de_AT-Store',
            'fr' => 'fr-Store',
            'fr-CH' => 'fr-ch-Store',
            'en' => 'de_AT-Store',
            'nl' => 'nl-NL',
        );
    }
}