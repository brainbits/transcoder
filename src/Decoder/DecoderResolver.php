<?php

declare(strict_types=1);

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

use Brainbits\Transcoder\Exception\RuntimeException;

use function sprintf;

/**
 * Decoder resolver.
 * Resolves decoders based on supported type.
 */
class DecoderResolver implements DecoderResolverInterface
{
    /** @var DecoderInterface[] */
    private array $decoders = [];

    /**
     * @param DecoderInterface[] $decoders
     */
    public function __construct(array $decoders = [])
    {
        foreach ($decoders as $decoder) {
            $this->addDecoder($decoder);
        }
    }

    public function resolve(?string $type): DecoderInterface
    {
        foreach ($this->decoders as $decoder) {
            if ($decoder->supports($type)) {
                return $decoder;
            }
        }

        throw new RuntimeException(sprintf('No decoder supports the requested type %s', (string) $type));
    }

    private function addDecoder(DecoderInterface $decoder): void
    {
        $this->decoders[] = $decoder;
    }
}
