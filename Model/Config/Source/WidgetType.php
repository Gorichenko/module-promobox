<?php

namespace VOID\Promobox\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use VOID\Promobox\Model\PromoboxWidget;

class WidgetType implements ArrayInterface
{
    protected $promoboxWidget;

    public function __construct(
        PromoboxWidget $promoboxWidget
    )
    {
        $this->promoboxWidget = $promoboxWidget;
    }

    public function toOptionArray()
    {
        $options = [];

        $widgets = $this->promoboxWidget->getCollection()
            ->addFieldToSelect(['widget_id', 'widget_title'])
            ->getData();

        foreach ($widgets as $item) {
            $options[] = [
                'value' => $item['widget_id'],
                'label' => $item['widget_title']
            ];
        }

        return $options;
    }
}
