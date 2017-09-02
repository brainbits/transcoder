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

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderResolverInterface;
use Brainbits\Transcoder\Encoder\EncoderResolverInterface;
use Psr\Log\LoggerInterface;

/**
 * Transcoder factory.
 * Creates transcoder object.
 */
class TranscoderFactory
{
    private $decoderResolver;
    private $encoderResolver;
    private $logger;

    public function __construct(
        DecoderResolverInterface $decoderResolver,
        EncoderResolverInterface $encoderResolver,
        LoggerInterface $logger
    ) {
        $this->decoderResolver = $decoderResolver;
        $this->encoderResolver = $encoderResolver;
        $this->logger = $logger;
    }

    public function createTranscoder(?string $inputType = null, ?string $outputType = null): Transcoder
    {
        $this->logger->debug("Creating transcoder with input type $inputType and output type $outputType");

        if ($inputType === $outputType) {
            $inputType = $outputType = null;
        }

        $decoder = $this->decoderResolver->resolve($inputType);
        $encoder = $this->encoderResolver->resolve($outputType);

        return new Transcoder($decoder, $encoder);
    }

}
