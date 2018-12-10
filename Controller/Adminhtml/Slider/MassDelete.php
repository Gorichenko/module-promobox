<?php

namespace VOID\Promobox\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use VOID\Promobox\Model\ResourceModel\PromoboxSlide\CollectionFactory;
use Magento\Framework\Filesystem\Driver\File;
use VOID\Promobox\Model\Banner\Image;

class MassDelete extends Action
{
    protected $filter;
    protected $collectionFactory;
    protected $file;
    protected $imageModel;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        File $file,
        Image $imageModel
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->file = $file;
        $this->imageModel = $imageModel;

        parent::__construct($context);
    }

    public function deleteSlide($backgroundImage)
    {
        if ($this->file->isExists($this->imageModel->getMediaDir() . '/' . $backgroundImage)) {
            $this->file->deleteFile($this->imageModel->getMediaDir() . '/' . $backgroundImage);
        }
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        if($this->isUsedByWidget($collection)) {
            $resultRedirect->setPath('*/*/');

            return $resultRedirect;
        }

        $delete = 0;

        try {
            foreach ($collection as $item) {
                $this->deleteSlide($item->getBackgroundImage());
                $item->delete();
                $delete++;
            }
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deletind the slide', $e->getMessage()));
            $resultRedirect->setPath('*/*/');

            return $resultRedirect;
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $delete));

        return $resultRedirect->setPath('*/*/');
    }

    public function isUsedByWidget($collection)
    {
        foreach ($collection as $item) {
            if (!empty($this->collectionFactory->create()->getUsingSlides($item->getSlideId()))) {
                $this->messageManager
                    ->addErrorMessage("Slide " . strtoupper($item->getSlideTitle()) . " can't be deleted, while it used by widget" );

                return true;
            }
        }

        return false;
    }
}
