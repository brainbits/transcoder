<?php

declare(strict_types=1);

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

use Brainbits\Transcoder\Exception\DecodeFailedException;
use Symfony\Component\Process\Process;

/**
 * 7z decoder.
 */
class SevenzDecoder implements DecoderInterface
{
    public const TYPE = '7z';

    private string $executable;

    public function __construct(string $executable = '7z')
    {
        $this->executable = $executable;
    }

    public function getExecutable(): string
    {
        return $this->executable;
    }

    public function decode(string $data): string
    {
        $process = $this->getProcess($data);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new DecodeFailedException('7z failure: ' . $process->getOutput() . $process->getErrorOutput());
        }

        $data = $process->getOutput();

        return $data;
    }

    public function supports(?string $type): bool
    {
        return $type === self::TYPE;
    }

    private function getProcess(string $data): Process
    {
        $process = new Process(
            [$this->executable, 'e', '-si', '-so', '-an', '-txz', '-m0=lzma2', '-mx=9', '-mfb=64', '-md=32m']
        );
        $process->setInput($data);

        return $process;
    }
}
