<?php

namespace yasMVC\Form\Element;

class Label extends Element
{
    protected $for;
    protected $text;
    
    public function __construct($for, $text)
    {
        $this->for = $for;
        $this->text = $text;
    }
    
    public function asHTML()
    {
        $returnValue = '<label for="' . $this->for . '"';
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }

        return $returnValue . '>' . $this->text . '</label>';
    }
}