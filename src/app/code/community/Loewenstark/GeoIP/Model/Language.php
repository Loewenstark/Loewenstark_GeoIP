<?php
/**
  * Loewenstark_GeoIP
  *
  * @category  Loewenstark
  * @package   Loewenstark_GeoIP
  * @author    Mathis Klooss <mathis.klooss@mage-profis.de>
  * @copyright 2014 Loewenstark Web-Solution GmbH (http://www.mage-profis.de). All rights served.
  */
class Loewenstark_GeoIP_Model_Language extends Varien_Object
{
    /**
     * get Language and iso Language
     * @example array('de' => array('de-AT', 'de-DE'))
     * 
     * @return array
     */
    public function getLanguagesArray()
    {
        if(!$this->hasData('languages_data'))
        {
            $country = $this->_getHelper()->getGeoCountry();
            // parse browser languages
            $countries = array($country);
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            {
                $langs = array();
                $split = array_filter((array)explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']));
                foreach($split as $_split)
                {
                    foreach(array_filter((array)explode(',', $_split)) as $_row)
                    {
                        if(substr($_row, 0, 2) != 'q=')
                        {
                            $short = $_row;
                            if($length = strpos($_row, '-'))
                            {
                                $short = substr($_row, 0, $length);
                                $part = substr($_row, ($length+1));
                                $countries[] = $part;
                                if(strtolower($part) == $short || $short == 'en')
                                {
                                    $_row = $short;
                                }
                            }
                            if(!strpos($_row, '-'))
                            {
                                $_row = $_row.'-'.$country;
                            }
                            if(!in_array($_row, $langs[$short]) && in_array($short, $this->_getConfig()->getLanguages()))
                            {
                                $langs[$short][] = $_row;
                            }
                        }
                    }
                }
                if(empty($langs))
                {
                    $langs = array($country => array($country.'-'.$country));
                }
                $this->setData('languages_data', $langs);
            } else {
                $this->setData('languages_data', array($country => array($country.'-'.$country)));
            }
            if(count($countries) == 0)
            {
                $countries = array($country);
            }
            $this->setData('country', array_unique($countries));
        }
        return $this->getData('languages_data');
    }
    
    /**
     * 
     */
    public function getLanguages()
    {
        if(!$this->hasData('languages'))
        {
            $data = array();
            $main = array();
            foreach($this->getLanguagesArray() as $key=>$value)
            {
                $main[] = $key;
                foreach($value as $lng)
                {
                    $data[] = $lng;
                }
            }
            $this->setData('languages', array_unique($data));
            $this->setData('main_languages', array_unique($main));
        }
        return $this->getData('languages');
    }
    
    /**
     * 
     */
    public function getMainLanguages()
    {
        if($this->hasData('main_languages'))
        {
            $this->getLanguages();
        }
        return $this->getData('main_languages');
    }
    
    /**
     * get Languages by Country
     * @example array('at' => array('de'))
     * 
     * @return array
     */
    public function getCountries()
    {
        if($this->hasData('country'))
        {
            $this->getLanguagesArray();
        }
        return $this->getData('country');
    }
    
    /**
     * 
     * @return Loewenstark_GeoIP_Helper_Config
     */
    protected function _getConfig()
    {
        return Mage::helper('loewenstark_geoip/config');
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
