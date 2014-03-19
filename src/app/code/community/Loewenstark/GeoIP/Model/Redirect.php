<?php

class Loewenstark_GeoIP_Model_Redirect
{
    protected $_languageClass = null;
    protected $_path_info = null;
    
    public function __construct()
    {
        Mage::dispatchEvent('loewenstark_geoip_model_redirect', array(
            'model' => $this
        ));
    }

    /**
     * 
     */
    public function run()
    {
        $obj = new Varien_Object();
        $obj->setRun(true); //
        Mage::dispatchEvent('loewenstark_geoip_model_redirect_before_run', array(
            'model' => $this,
            'obj' => $obj,
        ));
        if($obj->getRun())
        {
            $this->redirect();
        }
        // will only trigger when redirect is false
        Mage::dispatchEvent('loewenstark_geoip_model_redirect_after_run', array(
            'model' => $this
        ));
    }
    
    /**
     * 
     * @return Loewenstark_GeoIP_Model_Language
     */
    public function getLanguage()
    {
        if(is_null($this->_languageClass))
        {
            $this->_languageClass = Mage::getSingleton('loewenstark_geoip/language');
        }
        return $this->_languageClass;
    }

    /**
     * 
     * @param Loewenstark_GeoIP_Model_Language $class
     * @return Loewenstark_GeoIP_Model_Redirect
     */
    public function setLanguage($class)
    {
        $this->_languageClass = $class;
        return $this;
    }

    /**
     * 
     * @param string $path
     * @return Loewenstark_GeoIP_Model_Redirect
     */
    public function setPathInfo($path)
    {
        $this->_path_info = ltrim($path, '/');
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getPathInfo()
    {
        if(is_null($this->_path_info))
        {
            $this->setPathInfo(Mage::app()->getRequest()->getPathInfo());
        }
        return $this->_path_info;
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

    /**
     * 
     * @return Loewenstark_GeoIP_Model_Redirect
     */
    public function redirect()    
    {
        // check user agent before, like google or each other
        /** @todo need a defintion in the backend */
        if(Loewenstark_GeoIP_Zend_Http_UserAgent_Bot::match($this->_getHelper()->getUserAgent()))
        {
            return $this;
        }
        $this->_redirectLocaleCountry();
        $this->_redirectCountry();
        $this->_redirectContinent();
    }

    /**
     * redirect to locale country like de-CH
     * 
     * @return \Loewenstark_GeoIP_Model_Redirect
     */
    protected function _redirectLocaleCountry()
    {
        if($this->_getConfig()->isEnabled('storetolocalecountry'))
        {
            $config = $this->_getConfig()->getLocaleCountry();
            $store = null;
            foreach($this->getLanguage()->getLanguages() as $_language)
            {
                if(in_array($_language, $config))
                {
                    $store = array_search($_language, $config);
                    break;
                }
            }
            $this->_redirectToStore($store);
        }
        return $this;
    }

    /**
     * 
     * @return \Loewenstark_GeoIP_Model_Redirect
     */
    protected function _redirectCountry()
    {
        if($this->_getConfig()->isEnabled('storetocountry'))
        {
            $config = $this->_getConfig()->getCountry();
            $store = null;
            if(in_array($this->getLanguage()->getCurrentCountry(), $config))
            {
                $store = array_search($this->getLanguage()->getCurrentCountry(), $config);
            }
            $this->_redirectToStore($store);
        }
        return $this;
    }

    /**
     * 
     * @return \Loewenstark_GeoIP_Model_Redirect
     */
    protected function _redirectContinent()
    {
        if($this->_getConfig()->isEnabled('storetocountry'))
        {
            $config = $this->_getConfig()->getCountry();
            $store = null;
            if(in_array($this->getLanguage()->getCurrentContinent(), $config))
            {
                $store = array_search($this->getLanguage()->getCurrentContinent(), $config);
            }
            $this->_redirectToStore($store);
        }
        return $this;
    }

    /**
     * 
     * @param string|int $code
     * @return boolean
     */
    protected function _redirectToStore($code)
    {
        if(is_null($code))
        {
            return false;
        }
        if(!is_string($code))
        {
            $code = $this->_getConfig()->getStoreViewCode($code);
        }
        // check if code is positiv and not the same as the current store
        if($code && $this->_getConfig()->getCurrentStoreView() != $code)
        {
            $url = Mage::getUrl($this->getPathInfo(), array(
                '_store' => $code,
                '_escape' => false,
            ));
            $this->_getConfig()->log('Redirect to store "'.$code.'" from "'.$this->_getConfig()->getCurrentStoreView().'"');
            $this->_getSession()->setGeoIp(true);
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($url, 301)
                ->sendResponse();
            exit;
        }
        return false;
    }
    
    /**
     * 
     * @return Mage_Core_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('core/session');
    }
}