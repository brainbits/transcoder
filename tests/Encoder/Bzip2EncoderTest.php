<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests\Encoder;

use Brainbits\Transcoder\Encoder\Bzip2Encoder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\EncoderInterface
 * @covers \Brainbits\Transcoder\Encoder\Bzip2Encoder
 */
class Bzip2EncoderTest extends TestCase
{
    /**
      * @var Bzip2Encoder
      */
    private $encoder;

    protected function setUp()
    {
        $this->encoder = new Bzip2Encoder();
    }

    public function testEncode()
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $uncompressedResult = bzdecompress($result);

        $this->assertSame($testString, $uncompressedResult);
    }

    public function testSupports()
    {
        $this->assertTrue($this->encoder->supports('bzip2'));
        $this->assertFalse($this->encoder->supports('foo'));
    }
}
