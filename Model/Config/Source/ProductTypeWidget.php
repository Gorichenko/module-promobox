<?php

namespace VOID\Promobox\Model\Config\Source;

class ProductTypeWidget extends ProductType
{
    public function toArray()
    {
        $options = parent::toArray();

        unset($options[self::CATEGORY]);
        unset($options[self::CUSTOM_PRODUCTS]);

        return $options;
    }
}
