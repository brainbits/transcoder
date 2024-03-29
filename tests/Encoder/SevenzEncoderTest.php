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

use Brainbits\Transcoder\Encoder\SevenzEncoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brainbits\Transcoder\Encoder\SevenzEncoder
 */
class SevenzEncoderTest extends TestCase
{
    public function testEmptyConstructor(): void
    {
        $encoder = new SevenzEncoder();

        $this->assertSame('7z', $encoder->getExecutable());
    }

    public function testExecutable(): void
    {
        $encoder = new SevenzEncoder('foo');

        $this->assertSame('foo', $encoder->getExecutable());
    }

    public function testSupports(): void
    {
        $encoder = new SevenzEncoder();

        $this->assertTrue($encoder->supports('7z'));
        $this->assertFalse($encoder->supports('foo'));
    }

    public function testEncode(): void
    {
        $rc = null;
        $out = null;
        exec('which 7z', $out, $rc);

        if ($rc) {
            $this->markTestSkipped('7z not found on system, skipping');
            return;
        }

        $testString = 'a string to be compressed';

        $decoder = new SevenzEncoder();

        $result = $decoder->encode($testString);

        $this->assertNotEmpty($result);
        $this->assertNotSame($testString, $result);
    }
}
