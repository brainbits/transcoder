<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Encoder;

use Brainbits\Transcoder\Exception\EncodeFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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

    /**
     * @var string
     */
    private $data;

    /**
     * @param $executable string
     */
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
        $this->data = $data;

        $process = $this->getProcess();
        $process->run();

        if ($process->isSuccessful()) {
            $data = $process->getOutput();
        } else {
            throw new EncodeFailedException('7z failure: '.$process->getOutput().$process->getErrorOutput());
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return self::TYPE === $type;
    }

    /**
     * @return Process
     */
    private function getProcess()
    {
        $processBuilder = new ProcessBuilder([$this->executable, 'a', '-si', '-so', '-an', '-txz', '-m0=lzma2', '-mx=9', '-mfb=64', '-md=32m']);
        $processBuilder->setInput($this->data);

        return $processBuilder->getProcess();
    }
}
