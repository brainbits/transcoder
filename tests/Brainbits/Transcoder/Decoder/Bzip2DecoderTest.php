<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

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

    public function testSupports()
    {
        $this->assertTrue($this->decoder->supports('bzip2'));
        $this->assertFalse($this->decoder->supports('foo'));
    }
}
