<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderResolverInterface;
use Brainbits\Transcoder\Encoder\EncoderResolverInterface;
use Psr\Log\LoggerInterface;

/**
 * Transcoder factory
 * Creates transcoder object.
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class TranscoderFactory
{
    /**
     * @var DecoderResolverInterface
     */
    private $decoderResolver;

    /**
     * @var EncoderResolverInterface
     */
    private $encoderResolver;

    /**
     * @param DecoderResolverInterface $decoderResolver
     * @param EncoderResolverInterface $encoderResolver
     * @param LoggerInterface $logger
     */
    public function __construct(
        DecoderResolverInterface $decoderResolver,
        EncoderResolverInterface $encoderResolver,
        LoggerInterface $logger
    ) {
        $this->decoderResolver = $decoderResolver;
        $this->encoderResolver = $encoderResolver;
        $this->logger = $logger;
    }

    /**
     * @param null|string $inputType
     * @param null|string $outputType
     *
     * @return Transcoder
     */
    public function createTranscoder($inputType = null, $outputType = null)
    {
        $this->logger->debug('Creating transcoder with input type ' . $inputType . ' and output type ' . $outputType);

        if ($inputType === $outputType) {
            $inputType = $outputType = null;
        }

        $decoder = $this->decoderResolver->resolve($inputType);
        $encoder = $this->encoderResolver->resolve($outputType);

        return new Transcoder($decoder, $encoder);
    }

}
