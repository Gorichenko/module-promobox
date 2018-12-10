<?php

namespace VOID\Promobox\Controller\Adminhtml\Widget;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use VOID\Promobox\Controller\Adminhtml\Widget;
use VOID\Promobox\Model\PromoboxWidget;

class Edit extends Widget
{
    protected $resultPageFactory;

    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        PromoboxWidget $promoboxWidget,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;

        parent::__construct($context, $promoboxWidget, $coreRegistry);
    }

    public function execute()
    {
        $widget_id = $this->getRequest()->getParam('id');
        $widget = $this->initWidget($widget_id);
        if ($this->getRequest()->getParam('id') && !$widget->getId()) {
            $this->messageManager->addErrorMessage(__('This Widget no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $widget->getId(),
                    '_current'  => true
                ]
            );

            return $resultRedirect;
        }

        $data = $this->_session->getData('void_promobox_widget_data', true);
        if (!empty($data)) {
            $widget->setData($data);
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('VOID_Promobox::widget');
        $resultPage->getConfig()->getTitle()
            ->set(__('Widgets'))
            ->prepend($widget->getId() ? $widget->getWidgetTitle() : __('New Widget'));

        return $resultPage;
    }
}
