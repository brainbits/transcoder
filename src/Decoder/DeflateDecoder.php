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

use function gzinflate;

/**
 * Deflate decoder.
 */
class DeflateDecoder implements DecoderInterface
{
    public const TYPE = 'deflate';

    public function decode(string $data): string
    {
        $data = gzinflate($data);

        if (!$data) {
            throw new DecodeFailedException('gzinflate returned no data.');
        }

        return $data;
    }

    public function supports(?string $type): bool
    {
        return $type === self::TYPE;
    }
}
