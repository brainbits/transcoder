<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Transcoder;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @covers \Brainbits\Transcoder\Transcoder
 */
class TranscoderTest extends TestCase
{
    use ProphecyTrait;
    use TranscoderTestHelper;

    /**
     * @var ObjectProphecy|DecoderInterface
     */
    private $decoder;

    /**
     * @var ObjectProphecy|EncoderInterface
     */
    private $encoder;

    /**
     * @var Transcoder
     */
    private $transcoder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->decoder = $this->prophesizeDecoder();
        $this->encoder = $this->prophesizeEncoder();

        $this->transcoder = new Transcoder($this->decoder->reveal(), $this->encoder->reveal());
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(Transcoder::class, $this->transcoder);
    }

    public function testTranscode(): void
    {
        $encodedValue    = 'encoded';
        $decodedValue    = 'decoded';
        $transcodedValue = 'transcoded';

        $this->decoder->decode($encodedValue)->willReturn($decodedValue);

        $this->encoder->encode($decodedValue)->willReturn($transcodedValue);

        $result = $this->transcoder->transcode($encodedValue);

        $this->assertSame($transcodedValue, $result);
    }

}
