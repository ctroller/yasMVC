<?php

namespace yasMVC\Form\Element;

abstract class InputElement extends Element
{

    private $type;

    public function __construct($name, $type, $value = null)
    {
        parent::__construct($name);
        $this->type = $type;
        $this->value = $value;
    }

    public function asHTML()
    {
        $returnValue = '<input type="' . $this->type . '" name="' . $this->name . '" id="' . ( isset($this->id) ? $this->id : $this->name ) . '"';
        if ($this->value !== null) {
            $returnValue .= ' value="' . $this->value . '"';
        }
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }

        return $returnValue . ' />';
    }

}