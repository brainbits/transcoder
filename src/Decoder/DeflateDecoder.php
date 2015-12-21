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
 * Deflate decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class DeflateDecoder implements DecoderInterface
{
    const TYPE = 'deflate';

    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        $data = gzinflate($data);

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
