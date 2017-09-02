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
 * bzip2 encoder.
 */
class Bzip2Encoder implements EncoderInterface
{
    const TYPE = 'bzip2';

    public function encode(string $data): string
    {
        $data = bzcompress($data, 9);

        if (!$data) {
            throw new EncodeFailedException("bzcompress returned no data.");
        }

        return $data;
    }

    public function supports(?string $type): bool
    {
        return self::TYPE === $type;
    }
}
