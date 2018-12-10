<?php

namespace VOID\Promobox\Block\Article;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use VOID\Promobox\Model\PromoboxWidget;
use VOID\Promobox\Model\PromoboxSlide;
use Magento\Store\Model\StoreManagerInterface;
use VOID\Promobox\Helper\Data;
use VOID\Promobox\Block\AbstractSlider;
use Magento\Framework\App\Request\Http;

class Article extends Template implements BlockInterface
{
    protected $promoboxWidget;
    protected $promoboxSlide;
    protected $currentStore;
    protected $request;
    protected $helperData;

    public function __construct(
        PromoboxWidget $promoboxWidget,
        PromoboxSlide $promoboxSlide,
        Template\Context $context,
        StoreManagerInterface $currentStore,
        Http $request,
        Data $helperData,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->promoboxWidget = $promoboxWidget;
        $this->currentStore = $currentStore;
        $this->request = $request;
        $this->promoboxSlide = $promoboxSlide;
        $this->helperData = $helperData;
    }

    public function _construct()
    {
        parent::_construct();

        $this->setTemplate('VOID_Promobox::article/article.phtml');
    }

    public function getArticle()
    {
        $content = [];

        if ($this->promoboxSlide->load($this->request->getParam('articleId'))) {
            $content = [
                'article_title' => $this->promoboxSlide->getSlideTitle(),
                'article_text' => $this->promoboxSlide->getSlideText()
            ];
        }

        return $content;
    }
}
