<?php

namespace VOID\Promobox\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class SlideText extends \Magento\Ui\Component\Listing\Columns\Column
{
    const TEXT_LENGTH = 500;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$fieldName]) && strlen($item[$fieldName]) > self::TEXT_LENGTH) {
                    $item[$fieldName] = substr($item[$fieldName], 0, self::TEXT_LENGTH) . '...';
                }
            }
        }

        return $dataSource;
    }
}
