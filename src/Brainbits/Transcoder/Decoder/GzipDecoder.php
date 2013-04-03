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
 * Gzip decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class GzipDecoder implements DecoderInterface
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function decode($data)
    {
        $data = gzuncompress($data);
        Assertion::minLength($data, 1, 'gzdecode returned no data');
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return 'gzip' === $type;
    }
}
