<?php

namespace VOID\Promobox\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
