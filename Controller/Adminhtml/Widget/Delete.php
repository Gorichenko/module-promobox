<?php

namespace VOID\Promobox\Controller\Adminhtml\Widget;

use VOID\Promobox\Controller\Adminhtml\Widget;

class Delete extends Widget
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->widgetModel
                ->load($this->getRequest()->getParam('id'))
                ->delete();
            $this->messageManager->addSuccessMessage(__('The Widget has been deleted.'));
        } catch (\Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath('*/*/');

            return $resultRedirect;
        }

        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
