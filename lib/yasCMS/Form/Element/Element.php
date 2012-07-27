<?php

namespace yasMVC\Form\Element;

abstract class Element
{

    protected $attributes;
    protected $name;
    protected $value;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function hasAttributes()
    {
        return count($this->attributes) > 0;
    }

    abstract public function asHTML();
}