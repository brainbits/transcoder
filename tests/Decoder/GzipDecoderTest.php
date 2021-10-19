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

use Brainbits\Transcoder\Decoder\GzipDecoder;
use Brainbits\Transcoder\Exception\DecodeFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\GzipDecoder
 */
class GzipDecoderTest extends TestCase
{
    /**
      * @var GzipDecoder
      */
    private $decoder;

    protected function setUp(): void
    {
        $this->decoder = new GzipDecoder();
    }

    public function testDecode(): void
    {
        $testString    = 'a string to be decompressed';
        $encodedString = gzencode($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testDecodeThrowsErrorOnEmptyResult(): void
    {
        $this->expectException(DecodeFailedException::class);

        $testString    = '';
        $encodedString = gzencode($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->decoder->supports('gzip'));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
