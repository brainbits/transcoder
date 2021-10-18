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

namespace Brainbits\Transcoder;

/**
 * Transcoder interface.
 */
interface TranscoderInterface
{
    public function transcode(string $data): string;
}
