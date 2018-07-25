<?php
/**
 * Created by PhpStorm.
 * User: jamesle
 * Date: 20/07/2018
 * Time: 09:15
 */

namespace DataMapper\Interfaces;

interface MapInterface
{
    public function set($key, $lookup);
    public function setKey($key);
    public function setLookup($lookup);
    public function setData($data);
    public function setOnMapByLookup($onLoad);
    public function setOnMap($onSet);
    public function setFormControl($formControl);
    public function setValidation($validation);
    public function getKey();
    public function getLookup();
    public function getData();
    public function getOnMapByLookup();
    public function getOnMap();
    public function getFormControl();
    public function getValidation();
}