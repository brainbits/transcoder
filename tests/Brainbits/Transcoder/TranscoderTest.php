<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Tests\TranscoderTestHelper;
use PHPUnit_Framework_TestCase as TestCase;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @covers Brainbits\Transcoder\Transcoder
 * @covers Brainbits\Transcoder\Tests\TranscoderTestHelper
 */
class TranscoderTest extends TestCase
{
    use TranscoderTestHelper;

    /**
     * @var ObjectProphecy|DecoderInterface
     */
    private $decoderMock;

    /**
     * @var ObjectProphecy|EncoderInterface
     */
    private $encoderMock;

    /**
     * @var Transcoder
     */
    private $transcoder;

    protected function setUp()
    {
        parent::setUp();

        $this->decoderMock = $this->createDecoderMock();
        $this->encoderMock = $this->createEncoderMock();

        $this->transcoder = new Transcoder($this->decoderMock->reveal(), $this->encoderMock->reveal());
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Transcoder::class, $this->transcoder);
    }

    public function testTranscode()
    {
        $encodedValue    = 'encoded';
        $decodedValue    = 'decoded';
        $transcodedValue = 'transcoded';

        $this->decoderMock->decode($encodedValue)->willReturn($decodedValue);

        $this->encoderMock->encode($decodedValue)->willReturn($transcodedValue);

        $result = $this->transcoder->transcode($encodedValue);

        $this->assertSame($transcodedValue, $result);
    }

}
