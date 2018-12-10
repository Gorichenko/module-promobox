<?php

namespace VOID\Promobox\Model\Banner;

class Image
{
    const SUB_DIR = 'promobox/slides/image/';

    protected $urlBuilder;

    protected $fileSystem;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Filesystem $fileSystem
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }

    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . self::SUB_DIR . '/image';
    }

    public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath(self::SUB_DIR);
    }

    public function getMediaDir()
    {
        return $this->fileSystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
    }
}
