<?php

namespace VOID\Promobox\Block\Adminhtml\Widget\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected $slideCollection;
    protected $options = [];

    public function __construct(
        \VOID\Promobox\Model\ResourceModel\PromoboxSlide\Collection $slideCollection,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    )
    {
        $this->slideCollection = $slideCollection;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $slide = $this->_coreRegistry->registry('void_productslider_widget');
        $slideCollection = $this->slideCollection->addFieldToSelect(['slide_id', 'slide_title'])->getData();

        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'      => 'edit_form',
                    'action'  => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('widget_id')]),
                    'method'  => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $form->setHtmlIdPrefix('widget_');
        $form->setFieldNameSuffix('widget');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Widgets information'),
            'class'  => 'fieldset-wide'
        ]);

        $fieldset->addField('widget_id', 'hidden', [
            'name'     => 'widget_id'
        ]);
        $fieldset->addField('widget_title', 'text', [
            'name'     => 'widget_title',
            'label'    => __('Title'),
            'title'    => __('Title'),
            'required' => true
        ]);
        $fieldset->addField('widget_slides',
            'multiselect',
            [
                'label' => __('Widget Slides'),
                'required' => true,
                'name' => 'widget_slides[]',
                'values' => $this->toOptionArray($slideCollection)
            ]);
        $fieldset->addField('show_slide_text', 'checkbox', array(
            'label'    => __('Show Slide Text'),
            'onclick'   => 'this.value = this.checked ? 1 : 0;',
            'name'      => 'show_slide_text',
        ));

        $form->setValues($slide->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function toOptionArray(array $array)
    {
        foreach ($array as $item) {
            $this->options[] = [
                'value' => $item['slide_id'],
                'label' => $item['slide_title']
            ];
        }

        return $this->options;
    }
}
