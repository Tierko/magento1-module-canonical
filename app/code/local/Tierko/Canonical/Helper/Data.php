<?php

class Tierko_Canonical_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Getting value from config. Enable/disable forcing SSL for link.
     * @return string
     */
    private function _getForceHttps()
    {
        return Mage::getStoreConfig('tierko_canonical/canonical_settings/https');
    }

    /**
     * Getting value from config. Contains params, that was including in link.
     * @return array
     */
    private function _getParamConfig()
    {
        $paramsString = Mage::getStoreConfig('tierko_canonical/canonical_settings/params');
        return explode(',', $paramsString);
    }

    /**
     * @return string
     */
    private function _getCurrentLink()
    {
        $forceHttps = $this->_getForceHttps();
        return Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_forced_secure' => $forceHttps));
    }

    /**
     * Generating link for inserting in canonical rel
     * @return string
     */
    public function getCanonicalRel()
    {
        $link = $this->_getCurrentLink();
        $neededParams = $this->_getParamConfig();
        $params = Mage::app()
            ->getFrontController()
            ->getRequest()
            ->getParams();

        $findParams = array();

        foreach ($neededParams as $key => $neededParam) {
            if (array_key_exists($neededParam, $params)) {
                if ($neededParam === 'p' && ($params['p'] === 0 || $params['p'] === 1)) {
                    continue;
                }
                $findParams[$neededParam] = $params[$neededParam];
            }
        }

        if (!empty($findParams)) {
            $link .= '?' . http_build_query($findParams);
        }

        return $link;
    }
}