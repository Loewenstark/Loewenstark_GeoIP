<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Model_Backend_Config_System_Save_Locale
extends Loewenstark_GeoIP_Model_Backend_Config_System_Save
{

    /**
     * 
     * @return Loewenstark_GeoIP_Model_Backend_Config_System_Save
     */
    protected function _beforeSave()
    {
        $value = $this->_cleanValue($this->getValue());
        foreach($value as $key=>$result)
        {
            if(isset($result['locale']))
            {
                // dont panic, when you use the wrong syntax ;-)
                $value[$key]['locale'] = str_replace('_','-', trim($result['locale']));
            }
        }
        $this->setValue($value);
        return parent::_beforeSave();
    }
    
    /**
     * 
     * @return Loewenstark_GeoIP_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('loewenstark_geoip');
    }
}