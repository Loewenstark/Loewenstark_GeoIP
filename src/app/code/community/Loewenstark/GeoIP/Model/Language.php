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
    protected function _construct()
    {
        parent::_construct();
        Mage::dispatchEvent('loewenstark_geoip_model_language', array(
            'model' => $this
        ));
    }

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
            $country = $this->getCurrentCountry(); // get Current Country by IP
            // parse browser languages
            $countries = array($country);
            $lang = $this->_getHelper()->getBrowserLanguage();
            $i = 0;
            if(!empty($lang))
            {
                $langs = array();
                $split = array_filter((array)explode(';', $lang));
                unset($lang);
                foreach($split as $_split)
                {
                    foreach(array_filter((array)explode(',', $_split)) as $_row)
                    {
                        if(substr($_row, 0, 2) != 'q=')
                        {
                            if($i > 9)
                            {
                                break 2; // no one will have more than 9
                            }
                            $i++;
                            $short = $_row;
                            $normalLang = null;
                            if($length = strpos($_row, '-')) // split code in 2 parts: de-DE will be $short = de; $part = DE
                            {
                                $short = substr($_row, 0, $length);
                                $part = substr($_row, ($length+1));
                                $countries[] = $part;
                                if(strtolower($part) == $short || $short == 'en')
                                {
                                    $normalLang = $_row;
                                    $_row = $short;
                                }
                            } else { // if there is de-AT, we will add also de-DE
                                $normalLang = $_row.'-'.$this->_mapCountry($_row);
                            }
                            // if there is only the language without country definition we will add the country code
                            if(!strpos($_row, '-'))
                            {
                                $_row = $_row.'-'.$country;
                            }
                            
                            $langs[$short][] = $this->_isoLangCode($_row);
                            // always add normal language like de-DE / fr-DE
                            if($normalLang)
                            {
                                $langs[$short][] = $this->_isoLangCode($normalLang);
                            }
                            $langs[$short] = array_unique($langs[$short]);
                        }
                    }
                }
                if(empty($langs)) // fall back if there is no language
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
     * get All Languages
     * 
     * @return mixed
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
     * get all languages form data
     * 
     * return mixed
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
     * get Current Country ISO-Code2
     * 
     * @return string
     */
    public function getCurrentCountry()
    {
        return $this->_getHelper()->getGeoCountry();
    }

    /**
     * get Current Continent ISO-Code2
     * 
     * @return string
     */
    public function getCurrentContinent()
    {
        return $this->_getHelper()->getGeoContinent();
    }

    /**
     * mapping for languages without the same country like en-GB/en-US etc...
     * 
     * @param string $code
     * @return string
     */
    protected function _mapCountry($code)
    {
        $code = strtoupper($code);
        if($code == 'EN')
        {
            $code = 'US';
            if($this->getCurrentContinent() == 'EU')
            {
                $code = 'GB';
            }
        }
        return $code;
    }

    /**
     * the first 2 letter will be always lowercased and the last 2 chars are uppercase
     * 
     * @param string $code
     * @return string Language Code
     */
    protected function _isoLangCode($code)
    {
        $first = strtolower(substr($code,0, 3));
        $second = $this->_mapCountry(substr($code, 3, 2));
        return strtolower($first).strtoupper($second);
    }

    /**
     * 
     * system configuration
     * 
     * @return Loewenstark_GeoIP_Helper_Config
     */
    protected function _getConfig()
    {
        return Mage::helper('loewenstark_geoip/config');
    }

    /**
     * providing some data like, ip etc
     * 
     * @return Loewenstark_GeoIP_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('loewenstark_geoip');
    }
}
