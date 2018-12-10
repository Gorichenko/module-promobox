<?php

namespace VOID\Promobox\Controller\Adminhtml\Widget;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use VOID\Promobox\Controller\Adminhtml\Widget;
use VOID\Promobox\Model\PromoboxWidget;
use VOID\Promobox\Model\PromoboxSlide;
use VOID\Promobox\Model\PromoboxWidgetSlide;

class Save extends Widget
{
    protected $promoboxWidgetSlide;
    protected $promoboxSlide;

    public function __construct(
        Context $context,
        PromoboxWidget $promoboxWidget,
        PromoboxSlide $promoboxSlide,
        Registry $coreRegistry,
        PromoboxWidgetSlide $promoboxWidgetSlide
    )
    {
        parent::__construct($context, $promoboxWidget, $coreRegistry);
        $this->promoboxWidgetSlide = $promoboxWidgetSlide;
        $this->promoboxSlide = $promoboxSlide;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPost('widget')) {
            $widget = $this->initWidget($data['widget_id']);

            $widgetData = $data;
            $widgetData['widget_slides'] = $this->getSlideTitles($data['widget_slides']);

            if (isset($data['show_slide_text'])) {
                $widgetData['show_slide_text'] = true;
            } else {
                $widgetData['show_slide_text'] = false;
            }

            try{
                $widget->setData($widgetData);
                $widget->save();

                if (!empty($data['widget_id'])) {
                    $widgetId = $data['widget_id'];
                    $this->deleteWidgetSlides($widgetId);
                } else {
                    $widgetId = $widget->getCollection()->getLastItem()->getId();
                }

                $this->setWidgetSlideData($widgetId, $data['widget_slides']);

                if (!empty($data['widget_id'])) {
                    $this->messageManager->addSuccessMessage(__('Widget has been edited.'));
                } else {
                    $this->messageManager->addSuccessMessage(__('New widget has been saved.'));
                }

                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath('*/*/edit');

                    return $resultRedirect;
                }
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Widget. %1', $e->getMessage()));
                $resultRedirect->setPath('*/*/edit');

                return $resultRedirect;
            }
        }

        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }

    public function getSlideTitles($slideIds)
    {
        $slideTitles = [];
        foreach ($slideIds as $item) {
            $slide = $this->promoboxSlide->load($item);
            $slideTitles[] = $slide->getSlideTitle();
        }

        return implode(', ', $slideTitles);
    }

    public function setWidgetSlideData($widget_id, $slide_ids)
    {
        foreach ($slide_ids as $item) {
            $this->promoboxWidgetSlide->setData(
                ['widget_id' => $widget_id, 'slide_id' => $item]
            );
            $this->promoboxWidgetSlide->save();
        }
    }

    public function deleteWidgetSlides($widgetId)
    {
        $widgetSlideCollection = $this->promoboxWidgetSlide->getCollection();
        $widgetIds = $widgetSlideCollection->addFieldToSelect('id')
            ->addFieldToFilter('widget_id', $widgetId)
            ->getData();

        if ($widgetIds) {
            foreach ($widgetIds as $item) {
                $widgetSlideCollection->getItemById($item['id'])->delete();
            }
        }
    }
}
