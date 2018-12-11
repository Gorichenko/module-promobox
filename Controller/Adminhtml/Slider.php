<?php

namespace VOID\Promobox\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use VOID\Promobox\Model\PromoboxSlide;

abstract class Slider extends Action
{
    const ADMIN_RESOURCE = 'VOID_Promobox::slider';

    protected $slideModel;
    protected $coreRegistry;

    public function __construct(
        Context $context,
        PromoboxSlide $slideModel,
        Registry $coreRegistry
    )
    {
        $this->slideModel = $slideModel;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    protected function initSlider($id = null)
    {
        if ($id != null && $id != '') {
            $slider = $this->slideModel->load($id);
        } else {
            $slider = $this->slideModel;
        }

        $this->coreRegistry->register('void_promobox_slider', $slider);

        return $slider;
    }
}
