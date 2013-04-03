<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
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
     * @param string $data
     *
     * @return string
     */
    public function encode($data)
    {
        return $data;
    }
}
