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

use Brainbits\Transcoder\Encoder\GzipEncoder;
use PHPUnit\Framework\TestCase;

/**
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
        $this->encoder = new GzipEncoder();
    }

    public function testEncode()
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $uncompressedResult = gzdecode($result);

        $this->assertSame($testString, $uncompressedResult);
    }

    public function testSupports()
    {
        $this->assertTrue($this->encoder->supports('gzip'));
        $this->assertFalse($this->encoder->supports('foo'));
    }
}
