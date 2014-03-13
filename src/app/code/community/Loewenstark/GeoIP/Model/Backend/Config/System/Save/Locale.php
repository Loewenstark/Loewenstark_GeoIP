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
     * remove magentos empty first var
     * 
     * @return Loewenstark_GeoIP_Model_Backend_Config_System_Save
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        $value = $this->_cleanValue($value);
        foreach($value as $key=>$result)
        {
            if(isset($result['locale']))
            {
                $value[$key]['locale'] = str_replace('_','-', trim($result['locale']));
                if(strlen($result['locale']) != 5 || strstr($result['locale'], '-'))
                {
                    throw new Exception($this->_getHelper()->__('Wrong locale format'));
                }
            }
            
            if(!isset($result['locale']) && (isset($result['locale']) && empty($result['locale'])))
            {
                throw new Exception($this->_getHelper()->__('Missing locale'));
            }
            
        }
        echo '<pre>';
        var_dump($value); exit;
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