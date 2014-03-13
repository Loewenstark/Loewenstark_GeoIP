<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Model_Backend_Config_System_Save
extends Mage_Adminhtml_Model_System_Config_Backend_Serialized
{

    protected $_clean = false;

    /**
     * 
     */
    protected function _beforeSave()
    {
        if(!$this->_cleanValue)
        {
            $this->setValue($this->_cleanValue($this->getValue()));
        }
        if (is_array($this->getValue())) {
            $this->setValue(Mage::helper('core')->jsonEncode($this->getValue()));
        }
    }
    
    protected function _afterLoad()
    {
        if (!is_array($this->getValue())) {
            $value = $this->getValue();
            $this->setValue(empty($value) ? false : Mage::helper('core')->jsonDecode($value));
        }
    }
    
    /**
     * 
     * @param mixed $value
     * @return mixed
     */
    protected function _cleanValue($value)
    {
        // delete __empty key
        if(isset($value['__empty']))
        {
            unset($value['__empty']);
            $this->_clean = true;
        }
        return $value;
    }
}