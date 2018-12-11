<?php

namespace VOID\Promobox\Model;

use Magento\Framework\Model\AbstractModel;

class PromoboxSlide extends AbstractModel
{
    const CACHE_TAG = 'promobox_slides';

    protected $_cacheTag = 'promobox_slides';
    protected $_eventPrefix = 'promobox_slides';

    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\ResourceModel\PromoboxSlide');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
