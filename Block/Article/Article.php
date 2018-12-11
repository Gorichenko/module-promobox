<?php

namespace VOID\Promobox\Block\Article;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use VOID\Promobox\Model\PromoboxSlide;
use Magento\Framework\App\Request\Http;

class Article extends Template implements BlockInterface
{
    protected $promoboxSlide;

    public function __construct(
        PromoboxSlide $promoboxSlide,
        Template\Context $context,
        Http $request,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->promoboxSlide = $promoboxSlide;
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
