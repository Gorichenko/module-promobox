<?php

namespace VOID\Promobox\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    protected $coreRegistry;

    public function __construct(
        Registry $coreRegistry,
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->coreRegistry = $coreRegistry;
    }

    public function getHeaderText()
    {
        $slider = $this->getSlider();
        if ($slider->getId()) {
            return __("Edit Slider '%1'", $this->escapeHtml($slider->getName()));
        }

        return __('New Slide');
    }

    public function getSlider()
    {
        return $this->coreRegistry->registry('void_promobox_slider');
    }

    protected function _construct()
    {
        $this->_objectId   = 'slide_id';
        $this->_blockGroup = 'VOID_Promobox';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();
    }
}
