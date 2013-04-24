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
     * @var ProcessBuilder
     */
    private $processBuilder;

    /**
     * @param ProcessBuilder $processBuilder
     */
    public function __construct(ProcessBuilder $processBuilder)
    {
        $this->processBuilder = $processBuilder;
    }

    /**
     * Return executable
     *
     * @return string
     */
    public function getExecutable()
    {
        $commandline = $this->processBuilder->getProcess()->getCommandLine();
        $parts = explode(' ', $commandline);
        return $parts[0];
    }


    /**
     * @inheritDoc
     */
    public function encode($data)
    {
        $processBuilder = clone $this->processBuilder;

        $args=['a', '-si', '-so', '-an', '-txz', '-m0=lzma2', '-mx=9', '-mfb=64', '-md=32m'];
        foreach ($args as $arg) {
            $processBuilder->add($arg);
        }
        $processBuilder->setInput($data);

        $process = $processBuilder->getProcess();
        $process->run();

        if ($process->isSuccessful()) {
            $data = $process->getOutput();
        } else {
            throw new \Exception('7z failure:'.$process->getOutput().$process->getErrorOutput());
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
}
