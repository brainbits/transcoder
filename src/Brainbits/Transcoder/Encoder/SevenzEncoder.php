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

use Assert\Assertion as Assert;

/**
 * 7z encoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class SevenzEncoder implements EncoderInterface
{
    const TYPE = '7z';

    /**
     * @var string
     */
    private $executable;

    public function __construct($executable = '7z')
    {
        $this->executable = $executable;
    }

    /**
     * Return executable
     *
     * @return string
     */
    public function getExecutable()
    {
        return $this->executable;
    }

    /**
     * @inheritDoc
     */
    public function encode($data)
    {
        $command = escapeshellarg($this->executable) . ' a -an -txz -m0=lzma2 -mx=9 -mfb=64 -md=32m -ms=on -si -so';
        $process = proc_open($command, [ ['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w'] ], $pipes, null, null);

        $exitCode = 0;
        $errors = '';

        if (is_resource($process)) {
            fwrite($pipes[0], $data);
            fclose($pipes[0]);
            $data = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            $exitCode = proc_close($process);
        }

        Assert::minLength($data, 1, '7z encoder returned no data, exit code ' . $exitCode . ', error output ' . $errors);

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return self::TYPE === $type;
    }
}
