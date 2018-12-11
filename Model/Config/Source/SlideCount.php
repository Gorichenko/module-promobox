<?php

namespace VOID\Promobox\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class SlideCount implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8
        ];
    }
}
