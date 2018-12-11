<?php

namespace VOID\Promobox\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected function _prepareForm()
    {
        $slide = $this->_coreRegistry->registry('void_promobox_slider');

        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'      => 'edit_form',
                    'action'  => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('slide_id')]),
                    'method'  => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $form->setHtmlIdPrefix('slide_');
        $form->setFieldNameSuffix('slide');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Slide information'),
            'class'  => 'fieldset-wide'
        ]);
        $fieldset->addField('slide_id', 'hidden', [
            'name'     => 'slide_id'
        ]);
        $fieldset->addField('slide_title', 'text', [
            'name'     => 'slide_title',
            'label'    => __('Title'),
            'title'    => __('Title'),
            'required' => true
        ]);
        $fieldset->addField('slide_text', 'textarea', [
            'name'     => 'slide_text',
            'label'    => __('Slide Content'),
            'title'    => __('Slide Content'),
            'required' => true
        ]);
        $fieldset->addType('background_image', '\VOID\Promobox\Helper\ImageType');
        $fieldset->addField(
            'background_image',
            'background_image',
            [
                'name' => 'background_image',
                'label' => __('Background Image'),
                'title' => __('Background Image'),
                'note' => __('Recommended size: 400x600 px. Supported format: jpg, jpeg, gif, png.'),
                'field_extra_attributes' => 'required',
                'required' => true
            ]
        );
        $form->setValues($slide->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
