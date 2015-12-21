<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Process\ProcessBuilder;

/**
 * @covers \Brainbits\Transcoder\Decoder\DecoderInterface
 * @covers \Brainbits\Transcoder\Decoder\SevenzDecoder
 */
class SevenzDecoderTest extends TestCase
{
    /**
      * @var SevenzDecoder
      */
    private $decoder;

    protected function setUp()
    {
        $processBuilder = new ProcessBuilder(['7z']);
        $this->decoder = new SevenzDecoder($processBuilder);
    }

    public function testSupports()
    {
        $this->assertTrue($this->decoder->supports('7z'));
        $this->assertFalse($this->decoder->supports('foo'));
    }

    private function ensureExecutableAvailable()
    {
        $rc = null;
        $out = null;
        exec($this->decoder->getExecutable(), $out, $rc);

        if ($rc) {
            $this->markTestSkipped('7z not found on system, skipping');
        }
    }

}
