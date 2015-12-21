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
    public function createDecoderMock()
    {
        return $this->prophesize(DecoderInterface::class);
    }

    /**
     * @return ObjectProphecy|EncoderInterface
     */
    public function createEncoderMock()
    {
        return $this->prophesize(EncoderInterface::class);
    }

    /**
     * @return ObjectProphecy|EncoderResolver
     */
    public function createEncoderResolverMock()
    {
        $mock = $this->prophesize(EncoderResolver::class);

        return $mock;
    }

    /**
     * @return ObjectProphecy|DecoderResolver
     */
    public function createDecoderResolverMock()
    {
        $mock = $this->prophesize(DecoderResolver::class);

        return $mock;
    }

}
