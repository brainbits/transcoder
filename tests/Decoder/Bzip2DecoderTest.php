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

use Brainbits\Transcoder\Decoder\Bzip2Decoder;
use Brainbits\Transcoder\Exception\DecodeFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\Bzip2Decoder
 */
class Bzip2DecoderTest extends TestCase
{
    /**
      * @var Bzip2Decoder
      */
    private $decoder;

    protected function setUp(): void
    {
        $this->decoder = new Bzip2Decoder();
    }

    public function testDecode(): void
    {
        $testString    = 'a string to be decompressed';
        $encodedString = bzcompress($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testDecodeThrowsErrorOnEmptyResult(): void
    {
        $this->expectException(DecodeFailedException::class);

        $testString    = '';
        $encodedString = bzcompress($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    public function testDecodeError(): void
    {
        $this->expectException(DecodeFailedException::class);

        $testString = 'invalid encoded data';

        $this->decoder->decode($testString);
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->decoder->supports('bzip2'));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
