<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests\Encoder;

use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Encoder\EncoderResolver;
use Brainbits\Transcoder\Tests\TranscoderTestHelper;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \Brainbits\Transcoder\Encoder\EncoderResolver
 */
class EncoderResolverTest extends TestCase
{
    use TranscoderTestHelper;

    public function testResolveThrowsRuntimeExceptionWithoutDecoders()
    {
        $this->expectException(RuntimeException::class);

        $resolver = new EncoderResolver();

        $resolver->resolve('test');
    }

    public function testResolveRuntimeExceptionWithoutMatchingDecoder()
    {
        $this->expectException(RuntimeException::class);

        $encoder = $this->prophesizeEncoder();
        $encoder->supports('test')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolver = new EncoderResolver([$encoder->reveal()]);

        $resolver->resolve('test');
    }

    public function testResolveReturnsCorrectDecoder()
    {
        $encoder = $this->prophesizeEncoder();
        $encoder->supports('test')
            ->shouldBeCalled()
            ->willReturn(true);

        $resolver = new EncoderResolver([$encoder->reveal()]);

        $resolver->resolve('test');
    }
}
