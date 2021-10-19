<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Tests\Decoder;

use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Decoder\DecoderResolver;
use Brainbits\Transcoder\Tests\TranscoderTestHelper;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use RuntimeException;

/**
 * @covers \Brainbits\Transcoder\Decoder\DecoderResolver
 */
class DecoderResolverTest extends TestCase
{
    use ProphecyTrait;
    use TranscoderTestHelper;

    /**
     * @expectedException RuntimeException
     */
    public function testResolveThrowsRuntimeExceptionWithoutDecoders(): void
    {
        $this->expectException(RuntimeException::class);

        $resolver = new DecoderResolver();

        $resolver->resolve('test');
    }

    public function testResolveRuntimeExceptionWithoutMatchingDecoder(): void
    {
        $this->expectException(RuntimeException::class);

        $decoder = $this->prophesizeDecoder();
        $decoder->supports('test')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolver = new DecoderResolver([$decoder->reveal()]);

        $resolver->resolve('test');
    }

    public function testResolveReturnsCorrectDecoder(): void
    {
        $decoder = $this->prophesizeDecoder();
        $decoder->supports('test')
            ->shouldBeCalled()
            ->willReturn(true);

        $resolver = new DecoderResolver([$decoder->reveal()]);

        $resolver->resolve('test');
    }
}
