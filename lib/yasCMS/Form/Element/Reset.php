<?php

namespace yasMVC\Form\Element;

class Reset extends InputElement
{

    public function __construct($name, $value)
    {
        parent::__construct($name, 'reset', $value);
    }

}