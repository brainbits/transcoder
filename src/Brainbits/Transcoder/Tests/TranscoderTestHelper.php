<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Decoder\DecoderResolver;
use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Encoder\EncoderResolver;
use PHPUnit_Framework_MockObject_MockBuilder as MockObject;

/**
 * Test helper functions for transcoder.
 *
 * @author Phillip Look <plook@brainbits.net>
 *
 * @method MockBuilder getMockBuilder()
 * @method any()
 * @method returnValue()
 */
trait TranscoderTestHelper
{
    /**
     * @return MockObject|DecoderInterface
     */
    public function createDecoderMock()
    {
        return $this->getMockBuilder('Brainbits\Transcoder\Decoder\DecoderInterface')
            ->getMockForAbstractClass();
    }

    /**
     * @return MockObject|EncoderInterface
     */
    public function createEncoderMock()
    {
        return $this->getMockBuilder('Brainbits\Transcoder\Encoder\EncoderInterface')
            ->getMockForAbstractClass();
    }

    /**
     * @return MockObject|EncoderResolver
     */
    public function createEncoderResolverMock()
    {
        $mock = $this->getMockBuilder('Brainbits\Transcoder\Encoder\EncoderResolver')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())
            ->method('resolve')
            ->will($this->returnValue($this->createEncoderMock()));

        return $mock;
    }

    /**
     * @return MockObject|DecoderResolver
     */
    public function createDecoderResolverMock()
    {
        $mock = $this->getMockBuilder('Brainbits\Transcoder\Decoder\DecoderResolver')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())
            ->method('resolve')
            ->will($this->returnValue($this->createDecoderMock()));

        return $mock;
    }

}
