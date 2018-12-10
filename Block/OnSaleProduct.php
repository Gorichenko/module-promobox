<?php

namespace VOID\Promobox\Block;

class OnSaleProduct extends AbstractSlider
{
    public function getProductCollection()
    {
        $visibleProducts = $this->catalogProductVisibility->getVisibleInCatalogIds();
        $collection      = $this->productCollectionFactory->create()->setVisibility($visibleProducts);
        $collection      = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToFilter(
                'special_from_date',
                ['date' => true, 'to' => $this->getEndOfDayDate()], 'left'
            )->addAttributeToFilter(
                'special_to_date', ['or' => [0 => ['date' => true,
                                                   'from' => $this->getStartOfDayDate()],
                                             1 => ['is' => new \Zend_Db_Expr(
                                                 'null'
                                             )],]], 'left'
            )->addAttributeToSort(
                'news_from_date', 'desc'
            )->addStoreFilter($this->getStoreId())->setPageSize(
                $this->getProductsCount()
            );

        return $collection;
    }
}