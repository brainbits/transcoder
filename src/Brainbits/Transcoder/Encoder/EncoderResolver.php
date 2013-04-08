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
 * Encoder resolver
 * Resolves decoders based on supported type
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class EncoderResolver implements EncoderResolverInterface
{
    /**
     * @var EncoderInterface[]
     */
    private $encoders = array();

    /**
     * @param EncoderInterface[] $encoders
     */
    public function __construct(array $encoders = array())
    {
        $this->encoders = $encoders;
    }

    /**
     * Add encoder
     *
     * @param EncoderInterface $encoder
     * @return $this
     */
    public function addEncoder(EncoderInterface $encoder)
    {
        $this->encoders[] = $encoder;

        return $this;
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function resolve($type)
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($type)) {
                return $encoder;
            }
        }

        throw new \RuntimeException("No decoder supports the requested type $type");
    }
}
