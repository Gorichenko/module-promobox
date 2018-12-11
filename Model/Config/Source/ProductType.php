<?php

namespace VOID\Promobox\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ProductType implements ArrayInterface
{
    const NEW_PRODUCTS         = 'new';
    const BEST_SELLER_PRODUCTS = 'best-seller';
    const FEATURED_PRODUCTS    = 'featured';
    const MOSTVIEWED_PRODUCTS  = 'mostviewed';
    const ONSALE_PRODUCTS      = 'onsale';
    const RECENT_PRODUCT       = 'recent';

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
            self::NEW_PRODUCTS         => __('New Products'),
            self::BEST_SELLER_PRODUCTS => __('Best Seller Products'),
            self::FEATURED_PRODUCTS    => __('Featured Products'),
            self::MOSTVIEWED_PRODUCTS  => __('Most Viewed Products'),
            self::ONSALE_PRODUCTS      => __('On Sale Products'),
            self::RECENT_PRODUCT       => __('Recent Products')
        ];
    }

    public function getLabel($type)
    {
        $types = $this->toArray();
        if (isset($types[$type])) {
            return $types[$type];
        }

        return '';
    }

    public function getBlockMap($type = null)
    {
        $maps = [
            self::NEW_PRODUCTS         => 'VOID\Promobox\Block\NewProducts',
            self::BEST_SELLER_PRODUCTS => 'VOID\Promobox\Block\BestSellerProducts',
            self::FEATURED_PRODUCTS    => 'VOID\Promobox\Block\FeaturedProducts',
            self::MOSTVIEWED_PRODUCTS  => 'VOID\Promobox\Block\MostViewedProducts',
            self::ONSALE_PRODUCTS      => 'VOID\Promobox\Block\OnSaleProduct',
            self::RECENT_PRODUCT       => 'VOID\Promobox\Block\RecentProducts'
        ];

        if ($type && isset($maps[$type])) {
            return $maps[$type];
        }

        return $maps;
    }
}
