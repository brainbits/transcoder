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

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Encoder\EncoderInterface;

/**
 * Transcoder.
 */
class Transcoder implements TranscoderInterface
{
    private DecoderInterface $decoder;
    private EncoderInterface $encoder;

    public function __construct(DecoderInterface $decoder, EncoderInterface $encoder)
    {
        $this->decoder = $decoder;
        $this->encoder = $encoder;
    }

    public function transcode(string $data): string
    {
        $data = $this->decoder->decode($data);
        $data = $this->encoder->encode($data);

        return $data;
    }
}
