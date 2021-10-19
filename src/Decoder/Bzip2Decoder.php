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

use function bzdecompress;
use function is_string;

/**
 * Bzip2 decoder.
 */
class Bzip2Decoder implements DecoderInterface
{
    public const TYPE = 'bzip2';

    public function decode(string $data): string
    {
        $data = bzdecompress($data);

        if ($this->isErrorCode($data)) {
            throw new DecodeFailedException('bzdecompress failed.');
        }

        if (!$data) {
            throw new DecodeFailedException('bzdecompress returned no data.');
        }

        if (!is_string($data)) {
            throw new DecodeFailedException('bzdecompress returned error code.');
        }

        return $data;
    }

    public function supports(?string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * @param mixed $result
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
    private function isErrorCode($result): bool
    {
        return $result === -1 || $result === -2 || $result === -3 || $result === -5 || $result === -6 ||
            $result === -7 || $result === -8 || $result === -9;
    }
}
