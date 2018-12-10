<?php

namespace VOID\Promobox\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'productslider';

    protected $date;

    protected $httpContext;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        DateTime $date,
        HttpContext $httpContext
    )
    {
        $this->date          = $date;
        $this->httpContext   = $httpContext;

        parent::__construct($context, $objectManager, $storeManager);
    }

//    public function getActiveSliders()
//    {
//        /** @var Collection $collection */
//        $collection = $this->sliderFactory->create()
//            ->getCollection()
//            ->addFieldToFilter('customer_group_ids', ['finset' => $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)])
//            ->addFieldToFilter('status', 1);
//
//        $collection->getSelect()
//            ->where('FIND_IN_SET(0, store_ids) OR FIND_IN_SET(?, store_ids)', $this->storeManager->getStore()->getId())
//            ->where('from_date is null OR from_date <= ?', $this->date->date())
//            ->where('to_date is null OR to_date >= ?', $this->date->date());
//
//        return $collection;
//    }


    public function getProductSliderOptions()
    {
        $sliderOptions = '';
        $allConfig     = $this->getModuleConfig('product_slider');
        foreach ($allConfig as $key => $value) {
            if ($key == 'item_slider') {
                $sliderOptions = $sliderOptions . $this->getResponseValue();
            } else if ($key != 'responsive') {
                if(in_array($key, ['loop', 'nav', 'dots', 'lazyLoad', 'autoplay', 'autoplayHoverPause'])){
                    $value = $value ? 'true' : 'false';
                }
                $sliderOptions = $sliderOptions . $key . ':' . $value . ',' . PHP_EOL;
            }
        }

        return '{' . $sliderOptions . '}';
    }

    public function getPromoboxSliderOptions()
    {
        $sliderOptions = '';
        $allConfig     = $this->getModuleConfig('promobox_slider');
        foreach ($allConfig as $key => $value) {
            if ($key == 'item_slider') {
                $sliderOptions = $sliderOptions . $this->getResponseValue();
            } else if ($key != 'responsive') {
                if(in_array($key, [ 'loop', 'nav', 'dots', 'lazyLoad', 'autoplay', 'autoplayHoverPause'])){
                    $value = $value ? 'true' : 'false';
                }
                $sliderOptions = $sliderOptions . $key . ':' . $value . ',' . PHP_EOL;
            }
        }

        return '{' . $sliderOptions . '}';
    }

    public function isResponsive()
    {
        if ($this->getModuleConfig('slider_design/responsive') == 1) {
            return true;
        }

        return false;
    }

    public function getResponseValue()
    {
        $responsiveOptions = '';
        $responsiveConfig = $this->isResponsive() ? $this->unserialize($this->getModuleConfig('slider_design/item_slider')) : [];

        foreach ($responsiveConfig as $config) {
            if ($config['size'] && $config['items']) {
                $responsiveOptions = $responsiveOptions . $config['size'] . ':{items:' . $config['items'] . '},';
            }
        }

        $responsiveOptions = rtrim($responsiveOptions, ',');

        return 'responsive:{' . $responsiveOptions . '}';
    }

    function randomString($length = 5)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
