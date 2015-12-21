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
use Brainbits\Transcoder\Encoder;
use Brainbits\Transcoder\Decoder;
use Brainbits\Transcoder\Encoder\EncoderResolver;
use Brainbits\Transcoder\TranscoderFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;

/**
 * @covers Brainbits\Transcoder\TranscoderFactory
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
    public $encoderMock;

    /**
     * @var DecoderInterface|ObjectProphecy
     */
    public $decoderMock;

    /**
      * @var EncoderResolver|ObjectProphecy
      */
    private $encoderResolverMock;

    /**
      * @var DecoderResolver|ObjectProphecy
      */
    private $decoderResolverMock;

    /**
      * @var TranscoderFactory
      */
    private $transcoderFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->logger = $this->createLoggerMock();

        $this->encoderMock = $this->createEncoderMock();
        $this->decoderMock = $this->createDecoderMock();

        $this->encoderResolverMock = $this->createEncoderResolverMock();
        $this->decoderResolverMock = $this->createDecoderResolverMock();

        $this->transcoderFactory = new TranscoderFactory(
            $this->decoderResolverMock->reveal(),
            $this->encoderResolverMock->reveal(),
            $this->logger->reveal()
        );
    }

    public function testEncoderFactoryIsCalledWithEncoderType()
    {
        $expectedEncoder = 'encoder';

        $this->decoderResolverMock->resolve(null)->willReturn($this->decoderMock);
        $this->encoderResolverMock->resolve($expectedEncoder)->willReturn($this->encoderMock);

        $this->transcoderFactory->createTranscoder(null, $expectedEncoder);
    }

    public function testEncoderFactoryIsCalledWithDecoderType()
    {
        $expectedDecoder = 'decoder';

        $this->decoderResolverMock->resolve($expectedDecoder)->willReturn($this->decoderMock);
        $this->encoderResolverMock->resolve(null)->willReturn($this->encoderMock);

        $this->transcoderFactory->createTranscoder($expectedDecoder, null);
    }

    public function testPassThroughTranscoderIsCreatedForSameDecoderEncoder()
    {
        $expectedEncoder = $expectedDecoder = 'same';

        $this->encoderResolverMock->resolve(null)->willReturn($this->encoderMock);
        $this->decoderResolverMock->resolve(null)->willReturn($this->decoderMock);

        $this->transcoderFactory->createTranscoder($expectedDecoder, $expectedEncoder);
    }

    public function testTranscoderWasCreatedWithCreatedFactories()
    {
        $this->encoderResolverMock->resolve('encode')->willReturn($this->encoderMock);
        $this->decoderResolverMock->resolve('decode')->willReturn($this->decoderMock);

        $this->encoderMock->encode(Argument::any())->shouldBeCalled();
        $this->decoderMock->decode(Argument::any())->shouldBeCalled();

        $transcoder = $this->transcoderFactory->createTranscoder('decode', 'encode');

        $transcoder->transcode('data');
    }

    /**
     * @return LoggerInterface|ObjectProphecy
     */
    private function createLoggerMock()
    {
        return $this->prophesize(LoggerInterface::class);
    }

}
