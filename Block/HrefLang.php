<?php

namespace Freire\HrefLang\Block;

use Freire\HrefLang\Helper\Data;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page;
use Magento\Store\Model\Group;
use Magento\Store\Model\Website;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;

/**
 * Class HrefLang
 * @package Freire\HrefLang\Block
 */
class HrefLang extends Template
{
    /**
     * @var CmsPageUrlPathGenerator
     */
    private $cmsPageUrlPathGenerator;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var Page
     */
    private $pageResource;

    /**
     * @var Http
     */
    private $request;

    /**
     * @var Data
     */
    private $helperData;

    /**
     * HrefLang constructor.
     * @param Context $context
     * @param Http $request
     * @param CmsPageUrlPathGenerator $cmsPageUrlPathGenerator
     * @param PageRepositoryInterface $pageRepository
     * @param Page $pageResource
     * @param Data $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Http $request,
        CmsPageUrlPathGenerator $cmsPageUrlPathGenerator,
        PageRepositoryInterface $pageRepository,
        Page $pageResource,
        Data $helperData,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->cmsPageUrlPathGenerator = $cmsPageUrlPathGenerator;
        $this->pageRepository = $pageRepository;
        $this->pageResource = $pageResource;
        $this->request = $request;
        $this->helperData = $helperData;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getDefaultLanguage()
    {
        return $this->helperData->getDefaultLanguage();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getHrefLangTags()
    {
        $tags = [];
        /**
         * @var $store StoreInterface
         */
        foreach ($this->getStores() as $store) {
            $url = $this->getStoreUrl($store);
            if ($url) {
                $tags[$this->helperData->getLocaleCode($store)] = $url;
            }
        }
        return (count($tags) > 1) ? $tags : null;
    }

    /**
     * @param $store
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getStoreUrl($store)
    {
        switch ($this->request->getFullActionName()) {
            case 'cms_page_view':
                    return $this->getCmsPageUrl($this->request->getParam('page_id'), $store);
            case 'cms_index_index':
                return $store->getBaseUrl();
        }
        return '';
    }

    /**
     * @param $id
     * @param $store
     * @return string|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCmsPageUrl($id, $store)
    {
        $page = $this->pageRepository->getById($id);
        $pageId = $this->pageResource->checkIdentifier($page->getIdentifier(), $store->getId());
        if ($pageId) {
            $storePage = $this->pageRepository->getById($pageId);
            $path = $this->cmsPageUrlPathGenerator->getUrlPath($storePage);
            return $store->getBaseUrl() . $path;
        }

        return null;
    }

    /**
     * @return array|StoreInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getStores()
    {
        if ($this->helperData->isSameWebSiteOnly()) {
            return $this->getSameWebsiteStores();
        }
        return $this->_storeManager->getStores();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getSameWebsiteStores()
    {
        $stores = [];
        /** @var Website $website */
        $website = $this->_storeManager->getWebsite();
        foreach ($website->getGroups() as $group) {
            /** @var Group $group */
            foreach ($group->getStores() as $store) {
                $stores[] = $store;
            }
        }
        return $stores;
    }
}
