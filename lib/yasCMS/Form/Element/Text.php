<?php

namespace yasCMS\Form\Element;

class Text extends InputElement
{

    public function __construct($name, $value)
    {
        parent::__construct($name, 'text', $value);
    }

}