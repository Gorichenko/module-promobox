<?php

namespace VOID\Promobox\Model\Upload;

use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem\Driver\File;

class Upload
{
    protected $uploaderFactory;
    protected $file;

    public function __construct(
        UploaderFactory $uploaderFactory,
        File $file
    )
    {
        $this->uploaderFactory = $uploaderFactory;
        $this->file = $file;
    }

    public function uploadFileAndGetName($input, $baseFolder, $destinationFolder, $slide)
    {
        $uploader = $this->uploaderFactory->create(array('fileId' => $input));
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowCreateFolders(false);
        $fileName = 'slide_image_' . (string)random_int(111111, 999999) . '.' . $uploader->getFileExtension();
        if (!$this->file->isDirectory($destinationFolder)) {
            $this->file->createDirectory($destinationFolder);
        }
        $uploader->save($destinationFolder, $fileName);

        if ($slide->getBackgroundImage()) {
            if ($this->file->isExists($baseFolder . '/' . $slide->getBackgroundImage())) {
                $this->file->deleteFile($baseFolder . '/' . $slide->getBackgroundImage());
            }
        }

        return $fileName;
    }
}
