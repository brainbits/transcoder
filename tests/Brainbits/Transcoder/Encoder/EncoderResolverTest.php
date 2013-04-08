<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\EncoderInterface
 * @covers \Brainbits\Transcoder\Encoder\EncoderResolver
 */
class EncoderResolverTest extends TestCase
{
    /**
      * @var EncoderResolver
      */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new EncoderResolver();
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
        $encoderMock = $this->getMockBuilder('Brainbits\Transcoder\Encoder\EncoderInterface')
            ->getMock();

        $encoderMock
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(false));

        $this->resolver->addEncoder($encoderMock);

        $this->resolver->resolve('test');
    }

    public function testResolveReturnsCorrectDecoder()
    {
        $encoderMock = $this->getMockBuilder('Brainbits\Transcoder\Encoder\EncoderInterface')
            ->getMock();

        $encoderMock
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true));

        $this->resolver->addEncoder($encoderMock);

        $this->resolver->resolve('test');
    }
}
