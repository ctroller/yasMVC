<?php

namespace yasMVC\Cache;

class File
{

    private $fileName;
    private $cacheTime;
    private $cacheFolder;

    public function __construct($fileName, $cacheFolder, $cacheTime = '1 day')
    {
        $this->fileName = $fileName;
        $this->cacheTime = $cacheTime;
        $this->cacheFolder = $cacheFolder;
    }

    public function exists()
    {
        return file_exists($this->getFile());
    }

    public function doCache($content)
    {
        if ($this->isExpired())
            file_put_contents($this->getFile(), $content);
    }

    public function isExpired()
    {
        if ($this->exists()) {
            $fileTime = filemtime($this->getFile());
            $time = strtotime('-' . $this->cacheTime);
            return $fileTime < $time;
        }

        return true;
    }

    public function getFile()
    {
        return $this->cacheFolder . '/' . $this->fileName;
    }

}