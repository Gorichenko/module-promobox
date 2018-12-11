<?php

namespace VOID\Promobox\Helper;

class ImageType extends \Magento\Config\Block\System\Config\Form\Field\Image
{
    protected function _getDeleteCheckbox()
    {
        return '';
    }

    public function getElementHtml()
    {
        $field = parent::getElementHtml();
        $pattern = 'type="file"';
        $subject = 'type="file" required="true"';

        return str_replace($pattern, $subject, $field);
    }
}
