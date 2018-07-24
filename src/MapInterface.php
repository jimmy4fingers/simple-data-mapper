<?php
/**
 * Created by PhpStorm.
 * User: jamesle
 * Date: 20/07/2018
 * Time: 09:15
 */

interface MapInterface
{
    /**
     * @param $key
     * @param $lookup
     * @return MapInterface
     */
    public function set($key, $lookup);
    public function setKey($key);
    public function setLookup($lookup);
    public function setData($data);
    public function setOnLoad($onLoad);
    public function setOnSet($onSet);
    public function setFormControl($formControl);
    public function setValidationRules($validationRules);
    public function getKey();
    public function get();
    public function getLookup();
    public function getData();
    public function getOnLoad();
    public function getOnSet();
    public function getFormControl();
    public function getValidationRules();
}