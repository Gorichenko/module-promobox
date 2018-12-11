<?php

namespace VOID\Promobox\Block\Widget;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use VOID\Promobox\Model\PromoboxWidget;
use Magento\Store\Model\StoreManagerInterface;
use VOID\Promobox\Helper\Data;
use VOID\Promobox\Block\AbstractSlider;

class Promobox extends Template implements BlockInterface
{
    protected $promoboxWidget;
    protected $currentStore;
    protected $helperData;

    public function __construct(
        PromoboxWidget $promoboxWidget,
        Template\Context $context,
        StoreManagerInterface $currentStore,
        Data $helperData,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->promoboxWidget = $promoboxWidget;
        $this->currentStore = $currentStore;
        $this->helperData = $helperData;
    }

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('VOID_Promobox::widget/promobox.phtml');
    }

    public function getSlideCollection()
    {
        if ($this->hasData('widget_type')) {
            $widgetType = $this->getData('widget_type');
            $collection = $this->promoboxWidget
                ->getCollection()
                ->getWidgetSlides($widgetType);

            if ($collection) {
                return $collection;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->currentStore
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl;
    }

    public function getSlideText($slide_text)
    {
        $result = substr($slide_text, 0, 200) . '...';

        return $result;
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getPromoboxSliderOptions()
    {
        return $this->helperData->getPromoboxSliderOptions();
    }

    public function getUniqueId()
    {
        return $this->helperData->randomString();
    }

    public function getArticleUrl($slideId)
    {
        return $this->getUrl("promo/article/article/", ['_query' => ['articleId' => $slideId]]);
    }
}
