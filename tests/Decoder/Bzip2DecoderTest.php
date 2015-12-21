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
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\DecoderInterface
 * @covers \Brainbits\Transcoder\Decoder\Bzip2Decoder
 */
class DecoderBzip2Test extends TestCase
{
    /**
      * @var Bzip2Decoder
      */
    private $decoder;

    protected function setUp()
    {
        $this->decoder = new Bzip2Decoder();
    }

    public function testDecode()
    {
        $testString    = 'a string to be decompressed';
        $encodedString = bzcompress($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    /**
     * @expectedException \Brainbits\Transcoder\Exception\DecodeFailedException
     */
    public function testDecodeThrowsErrorOnEmptyResult()
    {
        $testString    = '';
        $encodedString = bzcompress($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }

    /**
     * @expectedException \Brainbits\Transcoder\Exception\DecodeFailedException
     */
    public function testDecodeError()
    {
        $testString = 'invalid encoded data';

        $this->decoder->decode($testString);
    }

    public function testSupports()
    {
        $this->assertTrue($this->decoder->supports('bzip2'));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
