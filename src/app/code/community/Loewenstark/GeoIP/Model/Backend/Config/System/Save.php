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

    /**
     * remove magentos empty first var
     * 
     * @return Loewenstark_GeoIP_Model_Backend_Config_System_Save
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        // delete __empty key
        foreach($value as $key=>$row) {
            if($key == "__empty") {
                unset($value["__empty"]);
            }
        }
        $this->setValue($value);
        return parent::_beforeSave();
    }
}