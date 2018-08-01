<?php
/**
 * Created by PhpStorm.
 * User: jamesle
 * Date: 20/07/2018
 * Time: 10:33
 */

namespace DataMapper\Interfaces;

interface MapCollectionInterface
{
    public function get();
    public function add(MapInterface $map);
}