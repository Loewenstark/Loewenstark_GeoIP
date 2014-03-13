<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Block_Adminhtml_Config_System_Locale
extends Loewenstark_GeoIP_Block_Adminhtml_Config_System_Abstract
{

    protected $_label_locale = 'Locale';


    /**
     * 
     * @return type
     */
    protected function _getAttrRenderer()
    {
        if (!$this->_groupRenderer) {
            $this->_groupRenderer = $this->getLayout()->createBlock(
                'loewenstark_geoip/adminhtml_config_system_list_stores', '',
                array('is_render_to_js_template' => true)
            );
            $this->_groupRenderer->setClass('list_stores');
            $this->_groupRenderer->setExtraParams('style="width:250px"');
        }
        return $this->_groupRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('locale', array(
            'label' => Mage::helper('loewenstark_geoip')->__($this->_label_locale),
            'style' => 'width:100px',
        ));
        $this->addColumn('store', array(
            'label' => Mage::helper('loewenstark_geoip')->__('StoreView'),
            'renderer' => $this->_getAttrRenderer(),
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
        $row->setData(
            'option_extra_attr_' . $this->_getAttrRenderer()->calcOptionHash($row->getData('list')),
            'selected="selected"'
        );
    }
}