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
 * bzip2 encoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class Bzip2Encoder implements EncoderInterface
{
    const TYPE = 'bzip2';

    /**
     * @inheritDoc
     */
    public function encode($data)
    {
        $data = bzcompress($data, 9);

        if (!$data) {
            throw new EncodeFailedException("bzcompress returned no data.");
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
