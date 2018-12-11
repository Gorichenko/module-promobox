<?php

namespace VOID\Promobox\Model\ResourceModel\PromoboxSlide;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'slide_id';
    protected $_eventPrefix = 'promobox_slide_collection';
    protected $_eventObject = 'promobox_slide_collection';

    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\PromoboxSlide', 'VOID\Promobox\Model\ResourceModel\PromoboxSlide');
    }

    public function getUsingSlides($slide_id)
    {
        $slideCollection = $this->addFieldToFilter('pws.slide_id', $slide_id)
            ->addFieldToSelect('slide_id')
            ->join(
                ['pws' => 'promobox_widget_slide'],
                'main_table.slide_id = pws.slide_id',
                []
            );

        return $slideCollection->getData();
    }
}
