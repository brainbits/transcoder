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

/**
 * Null encoder
 *
 * @author Phillip Look <plook@brainbits.net>
 */
class NullEncoder implements EncoderInterface
{
    const TYPE = 'null';

    /**
     * @inheritDoc
     */
    public function encode($data)
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
