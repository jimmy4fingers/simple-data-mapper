<?php

namespace spec\DataMapper;

use DataMapper\Map;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapSpec extends ObjectBehavior
{
    /**
     * Implementation:
     * set($key,$lookup)->setAttributes()->setTriggers()->setValidation();
     * get() should return structured array used in MapCollection
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(Map::class);
    }

    function it_sets_key_and_lookup()
    {
        $this->set('key','lookup')->shouldReturnAnInstanceOf('\DataMapper\Map');
    }

    function it_sets_data()
    {
        $this->setData('my-data');
        $this->getData()->shouldReturn('my-data');
    }

    function it_sets_onLoad()
    {
        $this->setOnMapByLookup('on load function')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->getOnMapByLookup()->shouldReturn('on load function');
    }

    function it_sets_onSet()
    {
        $this->setOnMap('on set function')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->getOnMap()->shouldReturn('on set function');
    }

    function it_sets_formControl()
    {
        $this->setFormControl('form object')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->getFormControl()->shouldReturn('form object');
    }

    function it_sets_validationRules()
    {
        $this->setValidation('required|type')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->getValidation()->shouldReturn('required|type');
    }

    function it_daisy_chains()
    {
        $array = [
            'key' => 'my-key',
            'lookup' => 'my-lookup',
            'data' => 'my-data',
            'attributes' => [
                'triggers' => [
                    'onMapByLookup' => 'my-onload',
                    'onMap' => 'my-onset'
                ],
                'form_control' => 'my-form',
                'validation_rules' => 'my-validation'
            ]
        ];

        $this->setKey('my-key');
        $this->setLookup('my-lookup');

        $this
            ->setData('my-data')
            ->setOnMapByLookup('my-onload')
            ->setOnMap('my-onset')
            ->setFormControl('my-form')
            ->setValidation('my-validation');

        $this->getData()->shouldReturn('my-data');
        $this->getOnMapByLookup()->shouldReturn('my-onload');
        $this->getOnMap()->shouldReturn('my-onset');
        $this->getFormControl()->shouldReturn('my-form');
        $this->getValidation()->shouldReturn('my-validation');
    }

    function it_should_get_key()
    {
        $this->setKey('my-key');
        $this->getKey()->shouldReturn('my-key');
    }

    function it_should_get_lookup()
    {
        $this->setLookup('my-lookup');
        $this->getLookup()->shouldReturn('my-lookup');
    }
}
