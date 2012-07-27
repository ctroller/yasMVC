<?php

namespace yasMVC\Upload;

abstract class RenamePolicy
{
    protected $fileName;
    
    public function __construct($fileName) {
        $this->fileName = $fileName;
    }
    
    abstract public function rename();

}