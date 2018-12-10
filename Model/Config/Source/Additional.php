<?php

namespace VOID\Promobox\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Additional implements ArrayInterface
{
    const SHOW_PRICE  = 1;
    const SHOW_CART   = 2;
    const SHOW_REVIEW = 3;

    public function toOptionArray()
    {
        $options = [];

        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    protected function toArray()
    {
        return [
            self::SHOW_PRICE  => __('Price'),
            self::SHOW_CART   => __('Add to cart button'),
            self::SHOW_REVIEW => __('Review information')
        ];
    }
}
