<?php

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

/**
 * Gzip decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class GzipDecoder implements DecoderInterface
{
    const TYPE = 'gzip';

    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        $data = gzdecode($data);

        if (!$data) {
            throw new DecodeFailedException("gzinflate returned no data.");
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
