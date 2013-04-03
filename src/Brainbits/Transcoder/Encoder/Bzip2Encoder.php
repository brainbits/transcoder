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

use Assert\Assertion;

/**
 * bzip2 encoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class Bzip2Encoder implements EncoderInterface
{
    const TYPE = 'bzip2';

    /**
     * @param string $data
     *
     * @return string
     */
    public function encode($data)
    {
        $data = bzcompress($data, 9);

        Assertion::minLength($data, 1, 'bzcompress returned no data');

        return $data;
    }
}
