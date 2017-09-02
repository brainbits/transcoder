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

use Brainbits\Transcoder\Encoder\DeflateEncoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\DeflateEncoder
 */
class DeflateEncoderTest extends TestCase
{
    /**
      * @var DeflateEncoder
      */
    private $encoder;

    protected function setUp()
    {
        $this->encoder = new DeflateEncoder();
    }

    public function testEncode()
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $uncompressedResult = gzinflate($result);

        $this->assertSame($testString, $uncompressedResult);
    }

    public function testSupports()
    {
        $this->assertTrue($this->encoder->supports('deflate'));
        $this->assertFalse($this->encoder->supports('foo'));
    }
}
