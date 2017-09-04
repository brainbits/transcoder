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
use Brainbits\Transcoder\TranscoderFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;

/**
 * @covers \Brainbits\Transcoder\TranscoderFactory
 */
class TranscoderFactoryTest extends TestCase
{
    use TranscoderTestHelper;

    /**
      * @var LoggerInterface
      */
    private $logger;

    /**
     * @var EncoderInterface|ObjectProphecy
     */
    public $encoder;

    /**
     * @var DecoderInterface|ObjectProphecy
     */
    public $decoder;

    /**
      * @var EncoderResolver|ObjectProphecy
      */
    private $encoderResolver;

    /**
      * @var DecoderResolver|ObjectProphecy
      */
    private $decoderResolver;

    /**
      * @var TranscoderFactory
      */
    private $transcoderFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->logger = $this->prophesizeLogger();

        $this->encoder = $this->prophesizeEncoder();
        $this->decoder = $this->prophesizeDecoder();

        $this->encoderResolver = $this->prophesizeEncoderResolver();
        $this->decoderResolver = $this->prophesizeDecoderResolver();

        $this->transcoderFactory = new TranscoderFactory(
            $this->decoderResolver->reveal(),
            $this->encoderResolver->reveal(),
            $this->logger->reveal()
        );
    }

    public function testEncoderFactoryIsCalledWithEncoderType()
    {
        $expectedEncoder = 'encoder';

        $this->decoderResolver->resolve(null)
            ->shouldBeCalled()
            ->willReturn($this->decoder);

        $this->encoderResolver->resolve($expectedEncoder)
            ->shouldBeCalled()
            ->willReturn($this->encoder);

        $this->transcoderFactory->createTranscoder(null, $expectedEncoder);
    }

    public function testEncoderFactoryIsCalledWithDecoderType()
    {
        $expectedDecoder = 'decoder';

        $this->decoderResolver->resolve($expectedDecoder)
            ->shouldBeCalled()
            ->willReturn($this->decoder);

        $this->encoderResolver->resolve(null)
            ->shouldBeCalled()
            ->willReturn($this->encoder);

        $this->transcoderFactory->createTranscoder($expectedDecoder, null);
    }

    public function testPassThroughTranscoderIsCreatedForSameDecoderEncoder()
    {
        $expectedEncoder = $expectedDecoder = 'same';

        $this->encoderResolver->resolve(null)
            ->shouldBeCalled()
            ->willReturn($this->encoder);

        $this->decoderResolver->resolve(null)
            ->shouldBeCalled()
            ->willReturn($this->decoder);

        $this->transcoderFactory->createTranscoder($expectedDecoder, $expectedEncoder);
    }

    public function testTranscoderWasCreatedWithCreatedFactories()
    {
        $this->encoderResolver->resolve('encode')
            ->shouldBeCalled()
            ->willReturn($this->encoder);

        $this->decoderResolver->resolve('decode')
            ->shouldBeCalled()
            ->willReturn($this->decoder);

        $this->encoder->encode('foo')
            ->shouldBeCalled()
            ->willReturn('bar');

        $this->decoder->decode('data')
            ->shouldBeCalled()
            ->willReturn('foo');

        $transcoder = $this->transcoderFactory->createTranscoder('decode', 'encode');

        $result = $transcoder->transcode('data');

        $this->assertSame('bar', $result);
    }

    /**
     * @return LoggerInterface|ObjectProphecy
     */
    private function prophesizeLogger()
    {
        return $this->prophesize(LoggerInterface::class);
    }
}
