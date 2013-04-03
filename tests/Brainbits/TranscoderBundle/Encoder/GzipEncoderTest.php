<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\EncoderInterface
 * @covers \Brainbits\Transcoder\Encoder\GzipEncoder
 */
class GzipEncoderTest extends TestCase
{
    /**
      * @var GzipEncoder
      */
    private $encoder;

    protected function setUp()
    {
        parent::setUp();
        $this->encoder = new GzipEncoder();
    }

    public function testEncode()
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $uncompressedResult = gzdecode($result);

        $this->assertSame($testString, $uncompressedResult);
    }

}
