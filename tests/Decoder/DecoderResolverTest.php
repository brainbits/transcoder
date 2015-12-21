<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests\Decoder;

use Brainbits\Transcoder\Decoder\DecoderResolver;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\DecoderInterface
 * @covers \Brainbits\Transcoder\Decoder\DecoderResolver
 */
class DecoderResolverTest extends TestCase
{
    /**
      * @var DecoderResolver
      */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new DecoderResolver();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testResolveThrowsRuntimeExceptionWithoutDecoders()
    {
        $this->resolver->resolve('test');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testResolveRuntimeExceptionWithoutMatchingDecoder()
    {
        $decoderMock = $this->getMockBuilder('Brainbits\Transcoder\Decoder\DecoderInterface')
            ->getMock();

        $decoderMock
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(false));

        $this->resolver->addDecoder($decoderMock);

        $this->resolver->resolve('test');
    }

    public function testResolveReturnsCorrectDecoder()
    {
        $decoderMock = $this->getMockBuilder('Brainbits\Transcoder\Decoder\DecoderInterface')
            ->getMock();

        $decoderMock
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true));

        $this->resolver->addDecoder($decoderMock);

        $this->resolver->resolve('test');
    }
}
