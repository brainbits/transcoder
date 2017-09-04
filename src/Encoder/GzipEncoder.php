<?php

declare(strict_types = 1);

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

/**
 * gzip encoder.
 */
class GzipEncoder implements EncoderInterface
{
    const TYPE = 'gzip';

    public function encode(string $data): string
    {
        $data = gzencode($data, 9);

        if (!$data) {
            throw new EncodeFailedException("gzencode returned no data.");
        }

        return $data;
    }

    public function supports(?string $type): bool
    {
        return self::TYPE === $type;
    }
}
