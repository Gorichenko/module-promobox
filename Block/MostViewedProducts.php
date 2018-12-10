<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use VOID\Promobox\Helper\Data;
use VOID\Promobox\Model\ResourceModel\Report\Product\CollectionFactory as MostViewedCollectionFactory;

class MostViewedProducts extends AbstractSlider
{
    protected $mostViewedProductsFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        MostViewedCollectionFactory $mostViewedProductsFactory,
        array $data = []
    )
    {
        $this->mostViewedProductsFactory = $mostViewedProductsFactory;

        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $dateTime,
            $helperData,
            $httpContext,
            $data
        );
    }

    public function getProductCollection()
    {
        $collection = $this->mostViewedProductsFactory->create()
            ->addAttributeToSelect('*')
            ->setStoreId($this->getStoreId())->addViewsCount()
            ->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount());

        return $collection;
    }
}