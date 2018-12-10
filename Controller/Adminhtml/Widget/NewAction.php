<?php

namespace VOID\Promobox\Controller\Adminhtml\Widget;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
