<?php

namespace DataMapper;

use DataMapper\Interfaces\MapInterface;

class Map implements MapInterface
{
    private $key = '';
    private $lookup = '';
    private $data = '';
    private $onMapByLookup = '';
    private $onMap = '';
    private $formControl = '';
    private $validationRules = '';

    public function set($key, $lookup)
    {
        $instance = new self();
        $instance->setKey($key);
        $instance->setLookup($lookup);

        return $instance;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setLookup($lookup)
    {
        $this->lookup = $lookup;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setOnMapByLookup($onMapByLookup)
    {
        $this->onMapByLookup = $onMapByLookup;
        return $this;
    }

    public function setOnMap($onMap)
    {
        $this->onMap = $onMap;
        return $this;
    }

    public function setFormControl($formControl)
    {
        $this->formControl = $formControl;
        return $this;
    }

    public function setValidation($validationRules)
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getLookup()
    {
        return $this->lookup;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getOnMapByLookup()
    {
        return $this->onMapByLookup;
    }

    public function getOnMap()
    {
        return $this->onMap;
    }

    public function getFormControl()
    {
        return $this->formControl;
    }

    public function getValidation()
    {
        return $this->validationRules;
    }
}
