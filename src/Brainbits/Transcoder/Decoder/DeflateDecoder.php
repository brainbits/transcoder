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
 * Deflate decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class DeflateDecoder implements DecoderInterface
{
    const TYPE = 'deflate';

    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        $data = gzinflate($data);
        Assertion::minLength($data, 1, 'gzinflate returned no data');
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
