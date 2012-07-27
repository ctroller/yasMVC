<?php

namespace yasCMS\Form\Element;

class Checkbox extends InputElement
{
    public function __construct($name, $checked)
    {
        parent::__construct($name, 'checkbox', null);
        if( $checked ) {
            $this->checked = 'checked';
        }
    }

}