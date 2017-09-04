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

use Brainbits\Transcoder\Decoder\DeflateDecoder;
use Brainbits\Transcoder\Exception\DecodeFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\DeflateDecoder
 */
class DeflateDecoderTest extends TestCase
{
    /**
      * @var DeflateDecoder
      */
    private $decoder;

    protected function setUp()
    {
        $this->decoder = new DeflateDecoder();
    }

    public function testDecode()
    {
        $testString    = 'a string to be decompressed';
        $encodedString = gzdeflate($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testDecodeThrowsErrorOnEmptyResult()
    {
        $this->expectException(DecodeFailedException::class);

        $testString    = '';
        $encodedString = gzdeflate($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testSupports()
    {
        $this->assertTrue($this->decoder->supports('deflate'));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
