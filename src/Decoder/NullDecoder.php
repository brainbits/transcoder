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

/**
 * Null decoder.
 */
class NullDecoder implements DecoderInterface
{
    public const TYPE = 'null';

    public function decode(string $data): string
    {
        return $data;
    }

    public function supports(?string $type): bool
    {
        return $type === null || $type === self::TYPE;
    }
}
