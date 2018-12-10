<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use VOID\Promobox\Helper\Data;
use VOID\Promobox\Model\Config\Source\Additional;

abstract class AbstractSlider extends AbstractProduct
{
    protected $date;

    protected $helperData;

    protected $productCollectionFactory;

    protected $catalogProductVisibility;

    protected $httpContext;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->date = $dateTime;
        $this->helperData = $helperData;
        $this->httpContext = $httpContext;

        parent::__construct($context, $data);
    }

    abstract public function getProductCollection();

    public function getCacheKeyInfo()
    {
        return [
            'VOID_PROMOBOX_SLIDER',
            $this->_storeManager->getStore()->getId(),
            $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP),
            $this->getSliderId()
        ];
    }

    public function getDisplayAdditional()
    {
        $display = $this->getSlider()->getDisplayAdditional();
        if (!is_array($display)) {
            $display = explode(',', $display);
        }

        return $display;
    }

    public function canShowPrice()
    {
        return in_array(Additional::SHOW_PRICE, $this->getDisplayAdditional());
    }

    public function canShowReview()
    {
        return in_array(Additional::SHOW_REVIEW, $this->getDisplayAdditional());
    }

    public function canShowAddToCart()
    {
        return in_array(Additional::SHOW_CART, $this->getDisplayAdditional());
    }

    public function getSliderId()
    {
        if ($this->getSlider()) {
            return $this->getSlider()->getSliderId();
        }

        return time();
    }

    public function getTitle()
    {
        if ($title = $this->hasData('title')) {
            return $title;
        }

        if ($this->getSlider()) {
            return $this->getSlider()->getTitle();
        }

        return '';
    }

    public function getDescription()
    {
        if ($this->hasData('description')) {
            return $this->getData('description');
        }

        if ($this->getSlider()) {
            return $this->getSlider()->getDescription();
        }

        return '';
    }

    public function getAllOptions()
    {
        $sliderOptions = '';
        $allConfig = $this->helperData->getModuleConfig('slider_design');

        foreach ($allConfig as $key => $value) {
            if ($key == 'item_slider') {
                $sliderOptions = $sliderOptions . $this->getResponsiveConfig();
            } else if ($key != 'responsive') {
                if(in_array($key, ['loop', 'nav', 'dots', 'lazyLoad', 'autoplay', 'autoplayHoverPause'])){
                    $value = $value ? 'true' : 'false';
                }
                $sliderOptions = $sliderOptions . $key . ':' . $value . ',';
            }
        }

        return '{' . $sliderOptions . '}';
    }

    public function getResponsiveConfig()
    {
        $slider = $this->getSlider();
        if ($slider && $slider->getIsResponsive()) {
            try {
                if ($slider->getIsResponsive() == 2) {
                    return $responsiveConfig = $this->helperData->getResponseValue();
                } else {
                    $responsiveConfig = $slider->getResponsiveItems() ? $this->helperData->unserialize($slider->getResponsiveItems()) : [];
                }
            } catch (\Exception $e) {
                $responsiveConfig = [];
            }

            $responsiveOptions = '';
            foreach ($responsiveConfig as $config) {
                if ($config['size'] && $config['items']) {
                    $responsiveOptions = $responsiveOptions . $config['size'] . ':{items:' . $config['items'] . '},';
                }
            }
            $responsiveOptions = rtrim($responsiveOptions, ',');

            return 'responsive:{' . $responsiveOptions . '}';
        }

        return '';
    }

    public function getEndOfDayDate()
    {
        return $this->date->date(null, '23:59:59');
    }

    public function getStartOfDayDate()
    {
        return $this->date->date(null, '0:0:0');
    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getProductsCount()
    {
        if ($this->hasData('products_count')) {
            return $this->getData('products_count');
        }

        if ($this->getSlider()) {
            return $this->getSlider()->getLimitNumber() ?: 5;
        }

        return 5;
    }
}
