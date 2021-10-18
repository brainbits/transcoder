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

namespace Brainbits\Transcoder\Encoder;

use Brainbits\Transcoder\Exception\EncodeFailedException;

use function bzcompress;
use function is_string;

/**
 * bzip2 encoder.
 */
class Bzip2Encoder implements EncoderInterface
{
    public const TYPE = 'bzip2';

    public function encode(string $data): string
    {
        $data = bzcompress($data, 9);

        if (!$data) {
            throw new EncodeFailedException('bzcompress returned no data.');
        }

        if (!is_string($data)) {
            throw new EncodeFailedException('bzdecompress returned error code.');
        }

        return $data;
    }

    public function supports(?string $type): bool
    {
        return $type === self::TYPE;
    }
}
