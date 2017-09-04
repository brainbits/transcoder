<?php

declare(strict_types = 1);

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
 * Encoder resolver.
 * Resolves decoders based on supported type.
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
        foreach ($encoders as $encoder) {
            $this->addEncoder($encoder);
        }
    }

    public function resolve(?string $type): EncoderInterface
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($type)) {
                return $encoder;
            }
        }

        throw new \RuntimeException("No decoder supports the requested type $type");
    }

    private function addEncoder(EncoderInterface $encoder): void
    {
        $this->encoders[] = $encoder;
    }
}
