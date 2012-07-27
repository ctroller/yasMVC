<?php

namespace yasMVC\Form\Element;

class Submit extends InputElement
{

    public function __construct($name, $value)
    {
        parent::__construct($name, 'submit', $value);
    }

}