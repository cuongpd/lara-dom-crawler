<?php

namespace spec\VnCoder\VnCrawler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VnCrawlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('VnCoder\VnCrawler\VnCrawler');
    }
}
