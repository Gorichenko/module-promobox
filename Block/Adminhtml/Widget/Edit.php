<?php

namespace VOID\Promobox\Block\Adminhtml\Widget;

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
            return __("Edit Widget '%1'", $this->escapeHtml($slider->getName()));
        }

        return __('New Widget');
    }

    public function getSlider()
    {
        return $this->coreRegistry->registry('void_productslider_widget');
    }

    protected function _construct()
    {
        $this->_objectId   = 'widget_id';
        $this->_blockGroup = 'VOID_Productslider';
        $this->_controller = 'adminhtml_widget';

        parent::_construct();
    }
}
