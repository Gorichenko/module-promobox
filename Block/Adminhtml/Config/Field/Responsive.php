<?php

namespace VOID\Promobox\Block\Adminhtml\Config\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Responsive extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('size', ['label' => __('Screen size max'), 'renderer' => false]);
        $this->addColumn('items', ['label' => __('Number of items'), 'renderer' => false]);

        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add');
    }
}
