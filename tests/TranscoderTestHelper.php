<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Decoder\DecoderResolver;
use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Encoder\EncoderResolver;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Test helper functions for transcoder.
 *
 * @author Phillip Look <plook@brainbits.net>
 *
 * @method ObjectProphecy prophesize($class)
 */
trait TranscoderTestHelper
{
    /**
     * @return ObjectProphecy|DecoderInterface
     */
    public function prophesizeDecoder()
    {
        return $this->prophesize(DecoderInterface::class);
    }

    /**
     * @return ObjectProphecy|EncoderInterface
     */
    public function prophesizeEncoder()
    {
        return $this->prophesize(EncoderInterface::class);
    }

    /**
     * @return ObjectProphecy|EncoderResolver
     */
    public function prophesizeEncoderResolver()
    {
        return $this->prophesize(EncoderResolver::class);
    }

    /**
     * @return ObjectProphecy|DecoderResolver
     */
    public function prophesizeDecoderResolver()
    {
        return $this->prophesize(DecoderResolver::class);
    }
}
