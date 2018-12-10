<?php

namespace VOID\Promobox\Block\Widget;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use VOID\Promobox\Block\AbstractSlider;
use VOID\Promobox\Helper\Data;
use VOID\Promobox\Model\Config\Source\ProductType;
use Magento\Widget\Block\BlockInterface;

class Slider extends AbstractSlider implements BlockInterface
{
    const DISPLAY_TYPE_NEW_PRODUCTS = 'new';

    protected $productType;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        ProductType $productType,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $dateTime,
            $helperData,
            $httpContext,
            $data
        );

        $this->productType = $productType;
    }

    public function _construct()
    {
        parent::_construct();

        $this->setTemplate('VOID_Promobox::widget/productslider.phtml');
    }

    public function getProductCollection()
    {
        $collection = [];

        if ($this->hasData('product_type')) {
            $productType = $this->getData('product_type');

            $collection = $this->getLayout()->createBlock($this->productType->getBlockMap($productType))
                ->getProductCollection();
            $collection->setPageSize($this->getPageSize())->setCurPage($this->getCurrentPage());
        }

        return $collection;
    }

    public function getCacheKeyInfo()
    {
        if ($this->helperData->versionCompare('1.0.0')) {
            $this->serializer = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\Serialize\Serializer\Json::class);
            $params = $this->serializer->serialize($this->getRequest()->getParams());
        }
        else $params = serialize($this->getRequest()->getParams());

        return array_merge(
            parent::getCacheKeyInfo(),
            [
                $this->getData('page_var_name'),
                intval($this->getRequest()->getParam($this->getData('page_var_name'), 1)),
                $params
            ]
        );
    }

    public function getDisplayAdditional()
    {
        $display = $this->_helperData->getModuleConfig('general/display_information');
        if (!is_array($display)) {
            $display = explode(',', $display);
        }
        return $display;
    }

    public function getHelperData()
    {
        return $this->_helperData;
    }

    public function getDisplayType()
    {
        if (!$this->hasData('product_type')) {
            $this->setData('product_type', self::DISPLAY_TYPE_NEW_PRODUCTS);
        }
        return $this->getData('product_type');
    }

    public function getCurrentPage()
    {
        return abs((int)$this->getRequest()->getParam($this->getData('page_var_name')));
    }

    protected function getPageSize()
    {
        return $this->getProductsCount();
    }

    public function getProductsCount()
    {
        return $this->getData('products_count')?: 10;
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getProductSliderOptions()
    {
        return $this->_helperData->getProductSliderOptions();
    }

    public function getUniqueId()
    {
        return $this->_helperData->randomString();
    }
}
