<?php

namespace VOID\Promobox\Model\ResourceModel\PromoboxWidget;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'widget_id';


    protected $_eventPrefix = 'promobox_widget_collection';


    protected $_eventObject = 'promobox_widget_collection';


    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\PromoboxWidget', 'VOID\Promobox\Model\ResourceModel\PromoboxWidget');
    }

    public function getWidgetSlides($widget_id)
    {
        $slideCollection = $this->addFieldToFilter('pws.widget_id', $widget_id)
        ->join(
            ['pws' => 'promobox_widget_slide'],
            'main_table.widget_id = pws.widget_id',
            []
        )
        ->join(
            ['ps' => 'promobox_slides'],
            'pws.slide_id = ps.slide_id',
            ['ps.slide_id', 'ps.slide_title', 'ps.slide_text', 'ps.background_image']
        );

        return $slideCollection->getData();
    }
}
