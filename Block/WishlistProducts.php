<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory as WishlistCollectionFactory;
use VOID\Promobox\Helper\Data;

class WishlistProducts extends AbstractSlider
{
    protected $wishlistCollectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        WishlistCollectionFactory $wishlistCollectionFactory,
        array $data = []
    )
    {
        $this->wishlistCollectionFactory = $wishlistCollectionFactory;

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
        $collection = [];

        if ($this->customer->isLoggedIn()) {
            $wishlist = $this->wishlistCollectionFactory->create()
                ->addCustomerIdFilter($this->customer->getCustomerId());
            $productIds = null;

            foreach ($wishlist as $product) {
                $productIds[] = $product->getProductId();
            }
            $collection = $this->productCollectionFactory->create()->addIdFilter($productIds);
            $collection = $this->_addProductAttributesAndPrices($collection)->addStoreFilter($this->getStoreId())->setPageSize($this->getProductsCount());
        }

        return $collection;
    }
}
