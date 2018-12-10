<?php

namespace VOID\Promobox\Model\ResourceModel\Report\Product;

use Magento\Reports\Model\ResourceModel\Product\Collection as ReportCollection;

class Collection extends ReportCollection
{
    public function addViewsCount($from = '', $to = '')
    {
        $this->getSelect()->reset()
            ->from(
                ['report_table_views' => $this->getTable('report_event')],
                ['views' => 'COUNT(report_table_views.event_id)']
            )
            ->join(
                ['e' => $this->getProductEntityTableName()],
                'e.entity_id = report_table_views.object_id'
            )
            ->group('e.entity_id')
            ->order('views ' . self::SORT_ORDER_DESC)
            ->having('COUNT(report_table_views.event_id) > ?', 0);

        $eventTypes = $this->_eventTypeFactory->create()->getCollection();
        foreach ($eventTypes as $eventType) {
            if ($eventType->getEventName() == 'catalog_product_view') {
                $this->getSelect()->where('report_table_views.event_type_id = ?', (int)$eventType->getId());
                break;
            }
        }

        if ($from != '' && $to != '') {
            $this->getSelect()->where('logged_at >= ?', $from)->where('logged_at <= ?', $to);
        }

        return $this;
    }
}
