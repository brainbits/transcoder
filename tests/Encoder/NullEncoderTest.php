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

use Brainbits\Transcoder\Encoder\NullEncoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\NullEncoder
 */
class NullEncoderTest extends TestCase
{
    /**
      * @var NullEncoder
      */
    private $encoder;

    protected function setUp(): void
    {
        $this->encoder = new NullEncoder();
    }

    public function testEncode(): void
    {
        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $this->assertSame($testString, $result);
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->encoder->supports('null'));
        $this->assertTrue($this->encoder->supports(null));
        $this->assertFalse($this->encoder->supports('foo'));
    }
}
