<?php

namespace spec\DataMapper;

use DataMapper\MapCollection;
use DataMapper\Interfaces\MapInterface;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MapCollection::class);
    }

    function it_sets(MapInterface $map)
    {
        // mock MapInterface
        $map->getKey()->willReturn('my-key');
        $map->set('my-key','my-lookup')->willReturn(
            $map->getWrappedObject()
        );

        $this->add($map);
    }

    function it_gets(MapInterface $map)
    {
        // mock MapInterface
        $map->getKey()->willReturn('my-key');
        $map->set('my-key','my-lookup')->willReturn(
            $map->getWrappedObject()

        );

        $this->add($map);
        $this->get()->shouldReturn(["my-key" => $map]);
    }
}
