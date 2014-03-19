<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Block_Adminhtml_Config_System_Useragent
extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{

    protected $_label_locale = 'Locale';

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('ua', array(
            'label' => Mage::helper('loewenstark_geoip')->__('User Agent'),
            'style' => 'width:100px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('loewenstark_geoip')->__('Add new');
    }
    
    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        
    }
}