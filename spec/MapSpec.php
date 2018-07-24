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

    function it_gets_map_array()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => '',
            'attributes' => [
                'triggers' => [
                    'onLoad' => '',
                    'onSet' => ''
                ],
                'form_control' => '',
                'validation_rules' => ''
            ]
        ];

        $this->get()->shouldReturn($array);
    }

    function it_sets_data()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => 'my-data',
            'attributes' => [
                'triggers' => [
                    'onLoad' => '',
                    'onSet' => ''
                ],
                'form_control' => '',
                'validation_rules' => ''
            ]
        ];


        $this->setData('my-data');
        $this->get()->shouldReturn($array);
    }

    function it_sets_onLoad()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => '',
            'attributes' => [
                'triggers' => [
                    'onLoad' => 'on load function',
                    'onSet' => ''
                ],
                'form_control' => '',
                'validation_rules' => ''
            ]
        ];

        $this->setOnLoad('on load function')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->get()->shouldReturn($array);
    }

    function it_sets_onSet()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => '',
            'attributes' => [
                'triggers' => [
                    'onLoad' => '',
                    'onSet' => 'on set function'
                ],
                'form_control' => '',
                'validation_rules' => ''
            ]
        ];

        $this->setOnSet('on set function')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->get()->shouldReturn($array);
    }

    function it_sets_formControl()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => '',
            'attributes' => [
                'triggers' => [
                    'onLoad' => '',
                    'onSet' => ''
                ],
                'form_control' => 'form object',
                'validation_rules' => ''
            ]
        ];

        $this->setFormControl('form object')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->get()->shouldReturn($array);
    }

    function it_sets_validationRules()
    {
        $array = [
            'key' => '',
            'lookup' => '',
            'data' => '',
            'attributes' => [
                'triggers' => [
                    'onLoad' => '',
                    'onSet' => ''
                ],
                'form_control' => '',
                'validation_rules' => 'required|type'
            ]
        ];

        $this->setValidationRules('required|type')->shouldReturnAnInstanceOf('\DataMapper\Map');
        $this->get()->shouldReturn($array);
    }

    function it_daisy_chains()
    {
        $array = [
            'key' => 'my-key',
            'lookup' => 'my-lookup',
            'data' => 'my-data',
            'attributes' => [
                'triggers' => [
                    'onLoad' => 'my-onload',
                    'onSet' => 'my-onset'
                ],
                'form_control' => 'my-form',
                'validation_rules' => 'my-validation'
            ]
        ];

        $this->setKey('my-key');
        $this->setLookup('my-lookup');

        $this
            ->setData('my-data')
            ->setOnLoad('my-onload')
            ->setOnSet('my-onset')
            ->setFormControl('my-form')
            ->setValidationRules('my-validation');

        $this->get()->shouldReturn($array);
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
