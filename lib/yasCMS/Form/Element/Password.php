<?php

namespace yasMVC\Form\Element;

class Password extends InputElement
{

    public function __construct($name)
    {
        parent::__construct($name, 'password');
    }

}