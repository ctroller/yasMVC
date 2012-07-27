<?php

namespace yasMVC\Form\Element;

class EmptyElement extends Element
{
    
    public function __construct() {}

    public function asHTML()
    {
        return '&nbsp;';
    }

}