<?php

namespace yasCMS\Upload;

class DefaultRenamePolicy extends RenamePolicy
{

    private $counter = 0;

    public function rename()
    {
        $parts = pathinfo($this->fileName);
        return $parts['filename'] . '_' . (++$this->counter ) . '.' . $parts['extension'];
    }

}

?>
