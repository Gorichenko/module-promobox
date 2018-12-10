<?php

namespace VOID\Promobox\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use VOID\Promobox\Helper\Data;

class PromoboxSlide extends AbstractDb
{
    protected $helper;
    protected $_isPkAutoIncrement = false;

    public function __construct(
        Context $context,
        Data $helper,
        $connectionName = null
    )
    {
        $this->helper = $helper;

        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init('promobox_slides', 'slide_id');
    }

}
