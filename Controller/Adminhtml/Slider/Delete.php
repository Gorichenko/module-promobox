<?php

namespace VOID\Promobox\Controller\Adminhtml\Slider;

use VOID\Promobox\Controller\Adminhtml\Slider;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Driver\File;
use VOID\Promobox\Model\Banner\Image;
use Magento\Framework\Registry;
use VOID\Promobox\Model\PromoboxSlide;

class Delete extends Slider
{
    protected $imageModel;
    protected $file;

    public function __construct(
        Context $context,
        File $file,
        Image $imageModel,
        Registry $registry,
        PromoboxSlide $promoboxSlideModel
    )
    {
        $this->imageModel = $imageModel;
        $this->file = $file;
        parent::__construct($context, $promoboxSlideModel, $registry);
    }

    public function deleteSlide($backgroundImage)
    {
        if ($this->file->isExists($this->imageModel->getMediaDir() . '/' . $backgroundImage)) {
            $this->file->deleteFile($this->imageModel->getMediaDir() . '/' . $backgroundImage);
        }
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $usingSlides = $this->slideModel->getCollection()->getUsingSlides($this->getRequest()->getParam('id'));

        if (!empty($usingSlides)) {
            $this->messageManager->addErrorMessage("Slide can't be deleted, while it used by widget");
            $resultRedirect->setPath('*/*/');

            return $resultRedirect;
        }

        try {
            $slide = $this->slideModel->load($this->getRequest()->getParam('id'));
            $this->deleteSlide($slide->getBackgroundImage());
            $slide->delete();
            $this->messageManager->addSuccessMessage(__('Slide has been deleted.'));
        } catch (\Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);

            return $resultRedirect;
        }

        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
