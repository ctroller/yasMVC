<?php

namespace yasCMS\Upload;

class File
{

    protected $tempFileName;
    protected $fileName;
    protected $uploadDir;
    protected $allowedMimeTypes = array(
        'application/pdf',
        'image/jpeg',
        'image/png',
        'image/gif'
    );

    public function __construct($filesArrayIdentifier, $uploadDir)
    {
        $this->tempFileName = $_FILES[$filesArrayIdentifier]['tmp_name'];
        $this->fileName = $_FILES[$filesArrayIdentifier]['name'];
        $this->uploadDir = $uploadDir;
    }

    public function validate()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $this->getTempFileName());
        finfo_close($finfo);
        return in_array($mimeType, $this->allowedMimeTypes);
    }

    protected function exists()
    {
        return file_exists($this->getFileName());
    }

    public function getFileName()
    {
        return $this->uploadDir . DS . $this->fileName;
    }

    public function getTempFileName()
    {
        return $this->tempFileName;
    }

    public function start($renamePolicyClassName = 'yasCMS\\Upload\\DefaultRenamePolicy')
    {
        if (!class_exists($renamePolicyClassName)) {
            //...
            return false;
        }

        if (is_uploaded_file($this->tempFileName)) {
            if ($this->validate()) {
                $renamePolicy = new $renamePolicyClassName($this->fileName);
                while ($this->exists()) {
                    $this->fileName = $renamePolicy->rename();
                }

                if (move_uploaded_file($this->tempFileName, $this->getFileName())) {
                    // ALL DONE
                    return true;
                }
            }

            return false;
        }
    }

}