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

/**
 * Decoder resolver interface.
 * Resolves decoders based on supported type.
 */
interface DecoderResolverInterface
{
    public function resolve(?string $type): DecoderInterface;
}
