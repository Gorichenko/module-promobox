<?php

namespace VOID\Promobox\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use VOID\Promobox\Controller\Adminhtml\Slider;
use VOID\Promobox\Model\PromoboxSlide;

class Edit extends Slider
{
    protected $resultPageFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        PromoboxSlide $promoboxSlide,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $promoboxSlide, $coreRegistry);
    }

    public function execute()
    {
        $slide_id = $this->getRequest()->getParam('id');
        $slider = $this->initSlider($slide_id);
        if ($slide_id && !$slider->getId()) {
            $this->messageManager->addErrorMessage(__('This Slider no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $slider->getId(),
                    '_current'  => true
                ]
            );

            return $resultRedirect;
        }

        $data = $this->_session->getData('void_promobox_slider_data', true);
        if (!empty($data)) {
            $slider->setData($data);
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('VOID_Promobox::slider');
        $resultPage->getConfig()->getTitle()
            ->set(__('Slide'))
            ->prepend($slider->getId() ? $slider->getSlideTitle() : __('New Slide'));

        return $resultPage;
    }
}
