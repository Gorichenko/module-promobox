<?php
namespace VOID\Promobox\Model;

use Mageplaza\Productslider\Model\ResourceModel\PromoboxSlide\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $promoboxSlideCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $promoboxSlideCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return [];
    }
}
