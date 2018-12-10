<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use VOID\Promobox\Helper\Data;

class CategoryId extends AbstractSlider
{
    protected $categoryFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        CategoryFactory $categoryFactory,
        array $data = []
    )
    {
        $this->categoryFactory = $categoryFactory;

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
        $productIds = $this->getProductIdsByCategory();
        $collection = [];
        if (!empty($productIds)) {
            $collection = $this->productCollectionFactory->create()->addIdFilter($productIds)->setPageSize($this->getProductsCount());;
            $this->_addProductAttributesAndPrices($collection);
        }

        return $collection;
    }

    public function getProductIdsByCategory()
    {
        $productIds = [];
        $catIds = $this->getSliderCategoryIds();
        foreach ($catIds as $catId) {
            $category = $this->categoryFactory->create()->load($catId);
            $collection = $this->productCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->addCategoryFilter($category);

            foreach ($collection as $item) {
                $productIds[] = $item->getData('entity_id');
            }
        }

        return $productIds;
    }

    public function getSliderCategoryIds()
    {
        if ($this->getData('category_id')) {
            return $this->getData('category_id');
        }
        if ($this->getSlider()) {
            $catIds = explode(',', $this->getSlider()->getCategoriesIds());

            return $catIds;
        }

        return 2;
    }
}
