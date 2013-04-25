<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Encoder\EncoderInterface;

/**
 * Transcoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class Transcoder
{
    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * @param DecoderInterface $decoder
     * @param EncoderInterface $encoder
     */
    public function __construct(DecoderInterface $decoder, EncoderInterface $encoder)
    {
        $this->decoder = $decoder;
        $this->encoder = $encoder;
    }

    /**
     * @param $data string
     * @return string
     */
    public function transcode($data)
    {
        $data = $this->decoder->decode($data);
        $data = $this->encoder->encode($data);

        return $data;
    }
}
