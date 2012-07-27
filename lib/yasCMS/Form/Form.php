<?php

namespace yasMVC\Form;

const FORM_METHOD_POST = "post";
const FORM_METHOD_GET = "get";
const FORM_METHOD_PUT = "put";

class Form
{

    protected $elements = array();
    protected $method;
    protected $action;
    protected $attributes = array();

    public function __construct($action, $method = FORM_METHOD_POST)
    {
        $this->action = $action;
        $this->method = $method;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function hasElements()
    {
        return count($this->elements) > 0;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function addElement(Element\Element $element)
    {
        $this->elements[] = $element;
    }

    public function getElement($index)
    {
        return array_key_exists($index, $this->elements) ? $this->elements[$key] : null;
    }

    public function asHTML()
    {
        $returnValue = $this->simpleHTML();
        $returnValue .= '<fieldset>';
        foreach ($this->elements as $element) {
            $returnValue .= $element->asHTML();
        }

        $returnValue .= '</fieldset></form>';
    }

    public function simpleHTML()
    {
        $returnValue = '<form method="' . $this->method . '" action="' . $this->action . '"';
        if ($this->hasAttributes()) {
            foreach ($this->attributes as $attribute => $value) {
                $returnValue .= ' ' . $attribute;
                if ($value !== null) {
                    $returnValue .= '="' . $value . '"';
                }
            }
        }
        return $returnValue . '>';
    }

    public function __set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public function hasAttributes()
    {
        return count($this->attributes) > 0;
    }

}