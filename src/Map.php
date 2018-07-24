<?php

/**
 * Class Map
 *
 * simple array class
 *
 */
class Map implements MapInterface
{
    private $key = '';
    private $lookup = '';
    private $data = '';
    private $onLoad = '';
    private $onSet = '';
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

    public function setOnLoad($onLoad)
    {
        $this->onLoad = $onLoad;
        return $this;
    }

    public function setOnSet($onSet)
    {
        $this->onSet = $onSet;
        return $this;
    }

    public function setFormControl($formControl)
    {
        $this->formControl = $formControl;
        return $this;
    }

    public function setValidationRules($validationRules)
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function get()
    {
        return [
            'key' => $this->key,
            'lookup' => $this->lookup,
            'data' => $this->data,
            'attributes' => [
                'triggers' => [
                    'onLoad' => $this->onLoad,
                    'onSet' => $this->onSet
                ],
                'form_control' => $this->formControl,
                'validation_rules' => $this->validationRules
            ]
        ];
    }

    /**
     * @return string
     */
    public function getLookup()
    {
        return $this->lookup;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getOnLoad()
    {
        return $this->onLoad;
    }

    /**
     * @return string
     */
    public function getOnSet()
    {
        return $this->onSet;
    }

    /**
     * @return string
     */
    public function getFormControl()
    {
        return $this->formControl;
    }

    /**
     * @return string
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }
}
