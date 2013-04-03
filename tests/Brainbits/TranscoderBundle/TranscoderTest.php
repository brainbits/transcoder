<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\Decoder;
use Brainbits\Transcoder\Encoder\Encoder;
use Brainbits\Transcoder\Tests\TranscoderTestHelper;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Brainbits\Transcoder\Transcoder
 * @covers Brainbits\Transcoder\Tests\TranscoderTestHelper
 */
class TranscoderTest extends TestCase
{
    use TranscoderTestHelper;

    /**
     * @var MockObject|Decoder
     */
    private $decoderMock;

    /**
     * @var MockObject|Encoder
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

        $this->transcoder = new Transcoder($this->decoderMock, $this->encoderMock);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('Brainbits\Transcoder\Transcoder', $this->transcoder);
    }


    public function testTranscode()
    {
        $encodedValue    = 'encoded';
        $decodedValue    = 'decoded';
        $transcodedValue = 'transcoded';

        $this->decoderMock
            ->expects($this->once())
            ->method('decode')
            ->with($encodedValue)
            ->will($this->returnValue($decodedValue));

        $this->encoderMock
            ->expects($this->once())
            ->method('encode')
            ->with($decodedValue)
            ->will($this->returnValue($transcodedValue));

        $result = $this->transcoder->transcode($encodedValue);

        $this->assertSame($transcodedValue, $result);
    }

}
