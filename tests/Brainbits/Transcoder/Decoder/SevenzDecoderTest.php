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
use Phlexible\Stdlib\Test\TestHelper;
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

    public function testDecode()
    {
        $this->ensureExecutableAvailable();

        $testString    = 'a string to be decompressed';
        $encodedString = $this->encode($testString);

        $result = $this->decoder->decode($encodedString);

        $this->assertSame($testString, $result);
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

    private function encode($data)
    {
        $process = proc_open(
            $this->decoder->getExecutable() . ' a -an -txz -m0=lzma2 -mx=9 -mfb=64 -md=32m -ms=on -si -so',
            [ ['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w'] ],
            $pipes,
            null,
            null
        );

        if (is_resource($process)) {
            fwrite($pipes[0], $data);
            fclose($pipes[0]);
            $data = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            $return_value = proc_close($process);
        }

        return $data;
    }
}
