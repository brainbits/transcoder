<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

/**
 * Decoder interface
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
interface DecoderInterface
{
    /**
     * Decode data
     *
     * @param string $data
     * @return string
     */
    public function decode($data);

    /**
     * Returns true if type is supported, false otherwise
     *
     * @param string $type
     * @return boolean
     */
    public function supports($type);
}
