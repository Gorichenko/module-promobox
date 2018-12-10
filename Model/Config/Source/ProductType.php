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
    const WISHLIST_PRODUCT     = 'wishlist';
    const CATEGORY             = 'category';
    const CUSTOM_PRODUCTS      = 'custom';

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
            self::RECENT_PRODUCT       => __('Recent Products'),
//            self::WISHLIST_PRODUCT     => __('WishList Products'),
            self::CATEGORY             => __('Select By Category'),
            self::CUSTOM_PRODUCTS      => __('Custom Specific Products'),
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
            self::NEW_PRODUCTS         => 'Mageplaza\Productslider\Block\NewProducts',
            self::BEST_SELLER_PRODUCTS => 'Mageplaza\Productslider\Block\BestSellerProducts',
            self::FEATURED_PRODUCTS    => 'Mageplaza\Productslider\Block\FeaturedProducts',
            self::MOSTVIEWED_PRODUCTS  => 'Mageplaza\Productslider\Block\MostViewedProducts',
            self::ONSALE_PRODUCTS      => 'Mageplaza\Productslider\Block\OnSaleProduct',
            self::RECENT_PRODUCT       => 'Mageplaza\Productslider\Block\RecentProducts',
            self::WISHLIST_PRODUCT     => 'Mageplaza\Productslider\Block\WishlistProducts',
            self::CATEGORY             => 'Mageplaza\Productslider\Block\CategoryId',
            self::CUSTOM_PRODUCTS      => 'Mageplaza\Productslider\Block\CustomProducts',
        ];

        if ($type && isset($maps[$type])) {
            return $maps[$type];
        }

        return $maps;
    }
}
