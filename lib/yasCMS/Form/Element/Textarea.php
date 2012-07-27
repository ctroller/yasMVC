<?php

namespace yasMVC\Form\Element;

class Textarea extends Element
{

    public function __construct($name, $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function asHTML()
    {
        $returnValue = '<textarea name="' . $this->name . '"';
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }

        return $returnValue . '>' . $this->value . '</textarea>';
    }

}