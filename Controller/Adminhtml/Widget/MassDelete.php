<?php

namespace VOID\Promobox\Controller\Adminhtml\Widget;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use VOID\Promobox\Model\ResourceModel\PromoboxWidget\CollectionFactory;

class MassDelete extends Action
{
    protected $filter;
    protected $widgetCollection;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $widgetCollection
    )
    {
        $this->filter = $filter;
        $this->widgetCollection = $widgetCollection;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $widgetCollection = $this->filter->getCollection($this->widgetCollection->create());
        $delete = 0;

        try {
            foreach ($widgetCollection as $item) {
                $item->delete();
                $delete++;
            }
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deletind the widgets', $e->getMessage()));
            $resultRedirect->setPath('*/*/');

            return $resultRedirect;
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $delete));

        return $resultRedirect->setPath('*/*/');
    }
}
