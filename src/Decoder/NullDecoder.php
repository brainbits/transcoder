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

/**
 * Null decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class NullDecoder implements DecoderInterface
{
    const TYPE = 'null';

    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return null === $type || self::TYPE === $type;
    }
}
