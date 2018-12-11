<?php

namespace VOID\Promobox\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use VOID\Promobox\Model\PromoboxWidget;

abstract class Widget extends Action
{
    const ADMIN_RESOURCE = 'VOID_Promobox::widget';

    protected $widgetModel;
    protected $coreRegistry;

    public function __construct(
        Context $context,
        PromoboxWidget $widgetModel,
        Registry $coreRegistry
    )
    {
        $this->widgetModel = $widgetModel;
        $this->coreRegistry  = $coreRegistry;

        parent::__construct($context);
    }

    protected function initWidget($id = null)
    {
        if ($id != null && $id != '') {
            $widget = $this->widgetModel->load($id);
        } else {
            $widget = $this->widgetModel;
        }

        $this->coreRegistry->register('void_promobox_widget', $widget);

        return $widget;
    }
}
