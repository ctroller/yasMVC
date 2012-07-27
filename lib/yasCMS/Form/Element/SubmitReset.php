<?php

namespace yasCMS\Form\Element;

class SubmitReset extends Element
{

    private $submit;
    private $reset;

    public function __construct($submitName, $submitValue, $resetName, $resetValue)
    {
        $this->submit = new Submit($submitName, $submitValue);
        $this->reset = new Reset($resetName, $resetValue);
    }

    public function asHTML()
    {
        return $this->submit->asHTML() . ' ' . $this->reset->asHTML();
    }

}