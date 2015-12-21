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
 * Encoder interface
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
interface EncoderInterface
{
    /**
     * Encode data
     *
     * @param string $data
     * @return string
     */
    public function encode($data);

    /**
     * Returns true if type is supported, false otherwise
     *
     * @param string $type
     * @return boolean
     */
    public function supports($type);
}
