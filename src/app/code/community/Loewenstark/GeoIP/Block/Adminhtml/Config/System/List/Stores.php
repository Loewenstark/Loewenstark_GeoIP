<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Block_Adminhtml_Config_System_List_Stores
extends Mage_Core_Block_Html_Select
{
/**
     * get Options
     * 
     * @return array
     */
    protected function _getOptions()
    {
        $options = array();
        $i = 0;
        foreach (Mage::app()->getWebsites() as $website)
        {
            foreach ($website->getGroups() as $group)
            {
                foreach ($group->getStores() as $store)
                {
                    $options[$store->getId()] = $website->getName().' - '.$group->getName().' - '.$store->getName();
                }
            }
        }
        return $options;
    }
    /**
     * alias for self::setName
     * 
     * @param string $value
     * @return string
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->_getOptions() as $id => $label) {
                $this->addOption($id, addslashes($label));
            }
        }
        return parent::_toHtml();
    }
}