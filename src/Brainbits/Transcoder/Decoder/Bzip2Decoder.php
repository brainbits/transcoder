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

use Assert\Assertion;

/**
 * Bzip2 decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class Bzip2Decoder implements DecoderInterface
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function decode($data)
    {
        $data = bzdecompress($data);
        Assertion::minLength($data, 1, 'bzdecompress returned no data');
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return 'bz2' === $type;
    }
}
