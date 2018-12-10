<?php

namespace VOID\Promobox\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class SlideActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['slide_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href'  => $this->urlBuilder->getUrl('promobox/slider/edit', ['id' => $item['slide_id']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href'  => $this->urlBuilder->getUrl('promobox/slider/delete', ['id' => $item['slide_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.slide_title }"'),
                                'message' => __('Are you sure you wan\'t to delete the Slide "${ $.$data.slide_title }" ?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
