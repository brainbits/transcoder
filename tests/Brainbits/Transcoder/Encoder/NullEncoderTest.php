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
 * @covers \Brainbits\Transcoder\Encoder\NullEncoder
 */
class NullEncoderTest extends TestCase
{
    /**
      * @var NullEncoder
      */
    private $encoder;

    protected function setUp()
    {
        $this->encoder = new NullEncoder();
    }

    public function testEncode()
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $this->assertSame($testString, $result);
    }

    public function testSupports()
    {
        $this->assertTrue($this->encoder->supports('null'));
        $this->assertTrue($this->encoder->supports(null));
        $this->assertFalse($this->encoder->supports('foo'));
    }
}
