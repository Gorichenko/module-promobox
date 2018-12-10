<?php

namespace VOID\Promobox\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use VOID\Promobox\Controller\Adminhtml\Slider;
use VOID\Promobox\Model\PromoboxSlide;
use VOID\Promobox\Model\Banner\Image;
use VOID\Promobox\Model\Upload\Upload;

class Save extends Slider
{
    protected $uploadModel;
    protected $imageModel;
    protected $uploaderFactory;
    protected $file;
    protected $upload;

    public function __construct(
        Context $context,
        PromoboxSlide $promoboxSlide,
        Registry $coreRegistry,
        Image $imageModel,
        Upload $upload
    )
    {
        $this->imageModel = $imageModel;
        $this->upload = $upload;
        parent::__construct($context, $promoboxSlide, $coreRegistry);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPost('slide')) {

            $slide = $this->initSlider($data['slide_id']);

                try {
                    $fileName = $this->upload->uploadFileAndGetName(
                        'background_image',
                        $this->imageModel->getMediaDir(),
                        $this->imageModel->getBaseDir(),
                        $slide
                    );

                    $data['background_image'] = Image::SUB_DIR . $fileName;
                } catch (\Exception $e) {
                    $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the slide', $e->getMessage()));
                    $resultRedirect->setPath('*/*/');

                    return $resultRedirect;
                }

            try {
                $slide->setData($data)->save();
                $this->messageManager->addSuccessMessage(__('Slide has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath('*/*/edit');

                    return $resultRedirect;
                }
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the slide. %1', $e->getMessage()));
                $resultRedirect->setPath('*/*/');

                return $resultRedirect;
            }
        }

        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
