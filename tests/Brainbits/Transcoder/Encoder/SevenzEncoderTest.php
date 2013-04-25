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
use Symfony\Component\Process\ProcessBuilder;

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
        $processBuilder = new ProcessBuilder(['7z']);
        $this->encoder = new SevenzEncoder($processBuilder);
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

}
