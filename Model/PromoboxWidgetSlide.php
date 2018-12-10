<?php

namespace VOID\Promobox\Model;

use Magento\Framework\Model\AbstractModel;

class PromoboxWidgetSlide extends AbstractModel
{
    const CACHE_TAG = 'promobox_widget_slide';

    protected $_cacheTag = 'promobox_widget_slide';

    protected $_eventPrefix = 'promobox_widget_slide';

    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\ResourceModel\PromoboxWidgetSlide');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
