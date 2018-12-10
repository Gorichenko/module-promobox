<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use VOID\Promobox\Helper\Data;

class BestSellerProducts extends AbstractSlider
{
    protected $bestSellersCollectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        BestSellersCollectionFactory $bestSellersCollectionFactory,
        array $data = []
    )
    {
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;

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
        $productIds  = [];
        $bestSellers = $this->bestSellersCollectionFactory->create()
            ->setPeriod('month');

        foreach ($bestSellers as $product) {
            $productIds[] = $product->getProductId();
        }

        $collection = $this->productCollectionFactory->create()->addIdFilter($productIds);
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('*')
            ->addStoreFilter($this->getStoreId())->setPageSize($this->getProductsCount());

        return $collection;
    }
}
