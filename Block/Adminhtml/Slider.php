<?php

namespace VOID\Promobox\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Slider extends Container
{
    protected function _construct()
    {
        $this->_controller     = 'adminhtml_slider';
        $this->_blockGroup     = 'VOID_Promobox';
        $this->_headerText     = __('Sliders');
        $this->_addButtonLabel = __('Create New Slider');
        parent::_construct();
    }
}
