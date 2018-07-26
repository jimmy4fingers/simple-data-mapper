<?php

namespace spec\DataMapper;

use DataMapper\Mapper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DataMapper\MapCollection;
use DataMapper\Map;

class MapperSpec extends ObjectBehavior
{
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

        $this->set($mappings, $testData, true);
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

        $this->set($mappings, $testData, true);
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

        $this->set($mappings, $testData);
        $this->get()->shouldReturn($expected);
    }

    function it_gets_data_by_key()
    {
        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('hiredPlantCover','pl.hired.plant.cover'));

        $this->set($mappings, ['pl.hired.plant.cover' => 'abcdefg'],true);
        $this->get('hiredPlantCover')->getData()->shouldReturn('abcdefg');
    }

    function it_uses_callable_trigger_in_set_mapping()
    {
        // onSet callback
        $uppercaseStringFunc = function ($data) {
            return strtoupper($data);
        };

        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('trigger_onset_test','pl.hired.plant.cover')->setOnMap($uppercaseStringFunc));

        $this->set($mappings, ['trigger_onset_test' => 'abcdefg']);
        $this->get('trigger_onset_test')->getData()->shouldReturn('ABCDEFG');
    }

    function it_users_callable_trigger_in_load_mapping()
    {
        // onLoad callback
        $explodeStringFunc = function ($data) {
            return explode(' ', $data);
        };
        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('trigger_load_test','pl.hired.plant.cover')->setOnMapByLookup($explodeStringFunc));

        $this->set($mappings, ['pl.hired.plant.cover' => 'a b c'],true);
        $this->get('trigger_load_test')->getData()->shouldReturn(['a','b','c']);
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

        $this->set($mappings, $dataToLoad);
        $this->getArray()->shouldReturn($dataToLoad);
    }

    function it_loads_data_from_diff_source()
    {
        $data = [
            'my_key' => 'my data value',
            'diff_source' => [0,1,2,3]
        ];

        $returns = [
            'my_key' => [0,1,2,3]
        ];

        $map = new Map();
        $mappings = new MapCollection();
        $mappings->add($map->set('my_key','my_lookup_key')->setDataFrom('diff_source'));

        $this->set($mappings, $data);
        $this->getArray()->shouldReturn($returns);
    }
}
