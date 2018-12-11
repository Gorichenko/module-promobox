<?php

namespace VOID\Promobox\Block;

class FeaturedProducts extends AbstractSlider
{
    public function getProductCollection()
    {
        $visibleProducts = $this->catalogProductVisibility->getVisibleInCatalogIds();

        $collection = $this->productCollectionFactory->create()->setVisibility($visibleProducts);
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('*')
            ->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount())
            ->addAttributeToFilter('is_featured', '1');

        return $collection;
    }
}
