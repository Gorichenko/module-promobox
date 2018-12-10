<?php

namespace VOID\Promobox\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Reports\Block\Product\Viewed as ReportProductViewed;
use VOID\Promobox\Helper\Data;

class RecentProducts extends AbstractSlider
{
    protected $reportProductViewed;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        Data $helperData,
        HttpContext $httpContext,
        ReportProductViewed $reportProductViewed,
        array $data = []
    )
    {
        $this->reportProductViewed = $reportProductViewed;

        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $dateTime,
            $helperData,
            $httpContext,
            $data
        );
    }

    public function getProductCollection()
    {
        return $this->reportProductViewed->getItemsCollection()->setPageSize($this->getProductsCount());
    }
}
