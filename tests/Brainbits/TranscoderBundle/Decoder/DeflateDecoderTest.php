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
 * @covers \Brainbits\Transcoder\Decoder\DeflateDecoder
 */
class DeflateDecoderTest extends TestCase
{
    /**
      * @var DecoderDeflate
      */
    private $decoder;

    protected function setUp()
    {
        parent::setUp();
        $this->decoder = new DeflateDecoder();
    }

    public function testDecode()
    {
        $testString    = 'a string to be decompressed';
        $encodedString = gzdeflate($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
    }
}
