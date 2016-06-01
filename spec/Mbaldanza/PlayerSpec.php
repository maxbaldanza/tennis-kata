<?php

namespace spec\Mbaldanza;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlayerSpec extends ObjectBehavior
{
    const NAME = 'test';

    function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MBaldanza\Player');
    }

    function it_should_return_name()
    {
        $this->getName()->shouldReturn(self::NAME);
    }
}
