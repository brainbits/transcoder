<?php

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
 * deflate encoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class DeflateEncoder implements EncoderInterface
{
    const TYPE = 'deflate';

    /**
     * @inheritDoc
     */
    public function encode($data)
    {
        $data = gzdeflate($data, 9);

        if (!$data) {
            throw new EncodeFailedException("gzdeflate returned no data.");
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
