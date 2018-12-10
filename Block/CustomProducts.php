<?php

namespace VOID\Promobox\Block;

class CustomProducts extends AbstractSlider
{
    public function getProductCollection()
    {
        $productIds = $this->getSlider()->getProductIds();
        if (!is_array($productIds)) {
            $productIds = explode('&', $productIds);
        }

        $collection = $this->productCollectionFactory->create()
            ->addIdFilter($productIds)
            ->setPageSize($this->getProductsCount());
        $this->_addProductAttributesAndPrices($collection);

        return $collection;
    }
}
