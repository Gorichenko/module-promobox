<?php

namespace VOID\Promobox\Model;

use Magento\Framework\Model\AbstractModel;

class PromoboxWidget extends AbstractModel
{
    const CACHE_TAG = 'promobox_widgets';

    protected $_cacheTag = 'promobox_widgets';

    protected $_eventPrefix = 'promobox_widgets';

    protected function _construct()
    {
        $this->_init('VOID\Promobox\Model\ResourceModel\PromoboxWidget');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
