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

use Assert\Assertion as Assert;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * 7z decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class SevenzDecoder implements DecoderInterface
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
     * @param $data
     */
    public function setInput($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Symfony\Component\Process\Process
     */
    public function getProcess()
    {
        $processBuilder = new ProcessBuilder(
            [$this->executable, 'e', '-si', '-so', '-an', '-txz', '-m0=lzma2', '-mx=9', '-mfb=64', '-md=32m']
        );
        $processBuilder->setInput($this->data);
        return $processBuilder->getProcess();
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
    public function decode($data)
    {
        $this->setInput($data);

        $process = $this->getProcess();
        $process->run();

        if ($process->isSuccessful()) {
            $data = $process->getOutput();
        } else {
            throw new \Exception('7z failure: '.$process->getOutput().$process->getErrorOutput());
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
