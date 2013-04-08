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
 * Decoder resolver
 * Resolves decoders based on supported type
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class DecoderResolver implements DecoderResolverInterface
{
    /**
     * @var DecoderInterface[]
     */
    private $decoders = array();

    /**
     * @param DecoderInterface[] $decoders
     */
    public function __construct(array $decoders = array())
    {
        $this->decoders = $decoders;
    }

    /**
     * Add decoder
     *
     * @param DecoderInterface $decoder
     * @return $this
     */
    public function addDecoder(DecoderInterface $decoder)
    {
        $this->decoders[] = $decoder;

        return $this;
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function resolve($type)
    {
        foreach ($this->decoders as $decoder) {
            if ($decoder->supports($type)) {
                return $decoder;
            }
        }

        throw new \RuntimeException("No decoder supports the requested type $type");
    }
}
