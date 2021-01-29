<?php
namespace Freire\HrefLang\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;

class Data extends AbstractHelper
{
    const XML_PATH_HREFLANG = 'hreflang/';

    /**
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return ($this->getGeneralConfig("enable")) ? true : false;
    }

    public function getDefaultLanguage()
    {
        return (strtolower(str_replace("_", "-", $this->getGeneralConfig("default_language"))));
    }

    /**
     * @return bool
     */
    public function isSameWebSiteOnly()
    {
        return ($this->getGeneralConfig("same_website_only")) ? true : false;
    }

    /**
     * @param StoreInterface $store
     * @return mixed
     */
    public function getLocaleCode(StoreInterface $store)
    {
        $localeCode = $this->scopeConfig->getValue('general/locale/code', 'stores', $store->getId());
        return str_replace('_', '-', strtolower($localeCode));
    }

    /**
     * @param $code
     * @param null $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HREFLANG .'general/'. $code, $storeId);
    }
}
