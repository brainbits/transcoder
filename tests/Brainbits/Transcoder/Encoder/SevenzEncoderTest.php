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
 * @covers \Brainbits\Transcoder\Encoder\SevenzEncoder
 */
class SevenzEncoderTest extends TestCase
{
    /**
      * @var SevenzEncoder
      */
    private $encoder;

    protected function setUp()
    {
        $this->encoder = new SevenzEncoder();
    }

    public function testEncode()
    {
        $this->ensureExecutableAvailable();

        $testString = 'a string to be compressed';

        $result = $this->encoder->encode($testString);

        $uncompressedResult = $this->decode($result);

        $this->assertSame($testString, $uncompressedResult);
    }

    public function testSupports()
    {
        $this->assertTrue($this->encoder->supports('7z'));
        $this->assertFalse($this->encoder->supports('foo'));
    }

    private function ensureExecutableAvailable()
    {
        $rc = null;
        $out = null;
        exec($this->encoder->getExecutable(), $out, $rc);

        if ($rc) {
            $this->markTestSkipped('7z not found on system, skipping');
        }
    }

    private function decode($data)
    {
        $process = proc_open(
            $this->encoder->getExecutable() . ' e -an -txz -m0=lzma2 -mx=9 -mfb=64 -md=32m -si -so',
            [ ['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w'] ],
            $pipes,
            null,
            null
        );

        if (strlen($data)) {
            if (is_resource($process)) {
                fwrite($pipes[0], $data);
                fclose($pipes[0]);
                $data = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $errors = stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                $return_value = proc_close($process);
            }
        }

        return $data;
    }
}
