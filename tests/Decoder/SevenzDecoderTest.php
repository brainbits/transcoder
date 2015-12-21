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

use Brainbits\Transcoder\Decoder\SevenzDecoder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Brainbits\Transcoder\Decoder\DecoderInterface
 * @covers \Brainbits\Transcoder\Decoder\SevenzDecoder
 */
class SevenzDecoderTest extends TestCase
{
    public function testEmptyConstructor()
    {
        $decoder = new SevenzDecoder();

        $this->assertSame('7z', $decoder->getExecutable());
    }

    public function testExecutable()
    {
        $decoder = new SevenzDecoder('foo');

        $this->assertSame('foo', $decoder->getExecutable());
    }

    public function testSupports()
    {
        $decoder = new SevenzDecoder();

        $this->assertTrue($decoder->supports('7z'));
        $this->assertFalse($decoder->supports('foo'));
    }

    public function testDecode()
    {
        $rc = null;
        $out = null;
        exec('7z', $out, $rc);

        if ($rc) {
            $this->markTestSkipped('7z not found on system, skipping');
            return;
        }

        $encodedString = file_get_contents(__DIR__ . '/../fixture/test.7z');

        $decoder = new SevenzDecoder();

        $result = $decoder->decode($encodedString);

        $this->assertSame('test' . PHP_EOL, $result);
    }
}
