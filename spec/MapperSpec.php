<?php

namespace spec\DataMapper;

use DataMapper\Mapper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DataMapper\MapCollection;
use DataMapper\Map;

class MapperSpec extends ObjectBehavior
{
    /**
     * Implementation:
     *
     * //////////////// load ////////////////////
     * $d3Data = array returned from D3
     * $mappings = new MapCollection();
     *
     * $mapper = new Mapper();
     * $mapper->load($mappings, $d3Data);
     * $mappedData = $mapper->get();
     *
     * //////////////// set ////////////////////
     * $formData = array post from GUI forms
     * $mappings = new MapCollection();
     *
     * $mapper = new Mapper();
     * $mapper->set($mappings, $formData);
     * $validationObj = $mapper->validate(validationObj)
     * $d3readyData = $mapper->get();
     *
     *
     * //// Additional functionality, build form elements using mapped data
     * $riskFormElements = new FormElementsMapper($mappedData);*
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(Mapper::class);
    }

    function it_throws_exception_if_get_called_before_set()
    {
        $this->shouldThrow('\Exception')->during('get');
    }

    function it_sets_data_by_lookup_key()
    {
        $map = new Map();
        $mappings = new MapCollection();

        $mappings->add($map->set('ownPlantCover','pl.own.plant'));
        $mappings->add($map->set('sumsInsuredForOwnPlant','pl.own.plant'));
        $mappings->add($map->set('hiredPlantCover','pl.hired.plant.cover'));
        $mappings->add($map->set('sumsInsuredForHiredInPlant','pl.hired.plant.si'));
        $mappings->add($map->set('gitCover','pl.git.cover'));
        $mappings->add($map->set('sumsGoodsInTransitCover','pl.git.si'));

        $testData = [
            'pl.own.plant' => 'test-data'
        ];

        $this->setDataByLookupKey($mappings, $testData);
    }

    function it_gets_data()
    {
        $map = new Map();
        $mappings = new MapCollection();

        $map1 = $map->set('ownPlantCover','pl.own.plant');
        $map2 = $map->set('sumsInsuredForOwnPlant','pl.own.plant');
        $map3 = $map->set('hiredPlantCover','pl.hired.plant.cover');
        $map4 = $map->set('sumsInsuredForHiredInPlant','pl.hired.plant.si');
        $map5 = $map->set('gitCover','pl.git.cover');
        $map6 = $map->set('sumsGoodsInTransitCover','pl.git.si');

        $mappings->add($map1);
        $mappings->add($map2);
        $mappings->add($map3);
        $mappings->add($map4);
        $mappings->add($map5);
        $mappings->add($map6);

        $testData = [
            'pl.own.plant' => '1234',
            'pl.own.plant.si' => 'sdfs',
            'pl.hired.plant.cover' => 'ghjgyu6',
            'pl.hired.plant.si' => 'hfghcfg',
            'pl.git.cover' => '9999',
            'pl.git.si' => '####',
        ];

        $expected = [
            'ownPlantCover' => $map1,
            'sumsInsuredForOwnPlant' => $map2,
            'hiredPlantCover' => $map3,
            'sumsInsuredForHiredInPlant' => $map4,
            'gitCover' => $map5,
            'sumsGoodsInTransitCover' => $map6
        ];

        $this->setDataByLookupKey($mappings, $testData);
        $this->get()->shouldReturn($expected);
    }

    function it_gets_set_data()
    {
        $map = new Map();
        $mappings = new MapCollection();

        $map1 = $map->set('ownPlantCover','pl.own.plant');
        $map2 = $map->set('sumsInsuredForOwnPlant','pl.own.plant');
        $map3 = $map->set('hiredPlantCover','pl.hired.plant.cover');
        $map4 = $map->set('sumsInsuredForHiredInPlant','pl.hired.plant.si');
        $map5 = $map->set('gitCover','pl.git.cover');
        $map6 = $map->set('sumsGoodsInTransitCover','pl.git.si');

        $mappings->add($map1);
        $mappings->add($map2);
        $mappings->add($map3);
        $mappings->add($map4);
        $mappings->add($map5);
        $mappings->add($map6);

        $testData = [
            'ownPlantCover' => '1234',
            'sumsInsuredForOwnPlant' => 'sdfs',
            'hiredPlantCover' => 'ghjgyu6',
            'sumsInsuredForHiredInPlant' => 'hfghcfg',
            'gitCover' => '9999',
            'sumsGoodsInTransitCover' => '####',
        ];

        $expected = [
            'ownPlantCover' => $map1,
            'sumsInsuredForOwnPlant' => $map2,
            'hiredPlantCover' => $map3,
            'sumsInsuredForHiredInPlant' => $map4,
            'gitCover' => $map5,
            'sumsGoodsInTransitCover' => $map6
        ];

        $this->setDataByKey($mappings, $testData);
        $this->get()->shouldReturn($expected);
    }

    function it_gets_data_by_key()
    {
        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('hiredPlantCover','pl.hired.plant.cover'));

        $this->setDataByLookupKey($mappings, ['pl.hired.plant.cover' => 'abcdefg']);
        $this->getData('hiredPlantCover')->shouldReturn('abcdefg');
    }

    function it_uses_callable_trigger_in_set_mapping()
    {
        // onSet callback
        $uppercaseStringFunc = function ($data) {
            return strtoupper($data);
        };

        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('trigger_onset_test','pl.hired.plant.cover')->setOnSet($uppercaseStringFunc));

        $this->setDataByKey($mappings, ['trigger_onset_test' => 'abcdefg']);
        $this->getData('trigger_onset_test')->shouldReturn('ABCDEFG');
    }

    function it_users_callable_trigger_in_load_mapping()
    {
        // onLoad callback
        $explodeStringFunc = function ($data) {
            return explode(' ', $data);
        };
        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('trigger_load_test','pl.hired.plant.cover')->setOnLoad($explodeStringFunc));

        $this->setDataByLookupKey($mappings, ['pl.hired.plant.cover' => 'a b c']);
        $this->getData('trigger_load_test')->shouldReturn(['a','b','c']);
    }

    function it_gets_with_data()
    {
        $map = new Map();
        $mappings = new MapCollection();

        $map1 = $map->set('ownPlantCover','pl.own.plant');
        $map2 = $map->set('sumsInsuredForOwnPlant','pl.own.plant');
        $map3 = $map->set('hiredPlantCover','pl.hired.plant.cover');
        $map4 = $map->set('sumsInsuredForHiredInPlant','pl.hired.plant.si');
        $map5 = $map->set('gitCover','pl.git.cover');
        $map6 = $map->set('sumsGoodsInTransitCover','pl.git.si');

        $mappings->add($map1);
        $mappings->add($map2);
        $mappings->add($map3);
        $mappings->add($map4);
        $mappings->add($map5);
        $mappings->add($map6);

        $dataToLoad = [
            'ownPlantCover' => '1234',
            'sumsInsuredForOwnPlant' => 'sdfs',
            'hiredPlantCover' => 'ghjgyu6',
            'sumsInsuredForHiredInPlant' => 'hfghcfg',
            'gitCover' => '9999',
            'sumsGoodsInTransitCover' => '####',
        ];

        $this->setDataByKey($mappings, $dataToLoad);
        $this->getWithData()->shouldReturn($dataToLoad);
    }
}
