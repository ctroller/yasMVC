<?php

namespace yasMVC\Form\Element;

class Select extends Element
{

    protected $options = array();

    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function asHTML()
    {
        $returnValue = '<select name="' . $this->name . '"';
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }

        $returnValue .= '>';
        foreach ($this->options as $option) {
            $returnValue .= $option->asHTML();
        }

        return $returnValue . '</select>';
    }

}