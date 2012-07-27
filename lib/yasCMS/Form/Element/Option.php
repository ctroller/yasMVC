<?php

namespace yasCMS\Form\Element;

class Option extends Element
{
    protected $text;

    public function __construct($value, $text)
    {
        parent::__construct(null);
        $this->value = $value;
        $this->text = $text;
    }

    public function asHTML()
    {
        $returnValue = '<option value="' . $this->value . '"';
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }

        return $returnValue . '>' . $this->text . '</option>';
    }

}