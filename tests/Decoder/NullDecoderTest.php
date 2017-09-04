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

use Brainbits\Transcoder\Decoder\NullDecoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\NullDecoder
 */
class NullDecoderTest extends TestCase
{
    /**
      * @var NullDecoder
      */
    private $decoder;

    protected function setUp()
    {
        $this->decoder = new NullDecoder();
    }

    public function testDecode()
    {
        $testString = 'a string to be decompressed';

        $result = $this->decoder->decode($testString);

        $this->assertSame($testString, $result);
    }

    public function testSupports()
    {
        $this->assertTrue($this->decoder->supports('null'));
        $this->assertTrue($this->decoder->supports(null));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
