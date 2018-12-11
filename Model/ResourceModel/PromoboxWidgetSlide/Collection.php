<?php

namespace VOID\Promobox\Model\ResourceModel\PromoboxWidgetSlide;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'promobox_widget_slide_collection';
    protected $_eventObject = 'promobox_widget_slide_collection';

    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\PromoboxWidgetSlide', 'VOID\Promobox\Model\ResourceModel\PromoboxWidgetSlide');
    }

    public function getIds($widgetid)
    {
        $result = [];
        $widgetCollection = $this->addFieldToSelect('id')
            ->addFieldToFilter('widget_id', $widgetid)
            ->getData();

        if ($widgetCollection) {
            foreach ($widgetCollection as $item) {
               $result[] = $item['id'];
            }
        }

        return $result;
    }
}
