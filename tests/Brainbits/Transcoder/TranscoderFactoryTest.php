<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder;

use Brainbits\Transcoder\Decoder\DecoderFactory;
use Brainbits\Transcoder\Decoder\DecoderInterface;
use Brainbits\Transcoder\Encoder\EncoderFactory;
use Brainbits\Transcoder\Encoder\EncoderInterface;
use Brainbits\Transcoder\Tests\TranscoderTestHelper;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * @covers Brainbits\Transcoder\TranscoderFactory
 * @covers Brainbits\Transcoder\Tests\TranscoderTestHelper
 */
class TranscoderFactoryTest extends TestCase
{
    use TranscoderTestHelper;

    /**
      * @var LoggerInterface
      */
    private $logger;

    /**
     * @var MockObject|EncoderInterface
     */
    public $encoderMock;

    /**
     * @var MockObject|DecoderInterface
     */
    public $decoderMock;

    /**
      * @var MockObject|EncoderResolver
      */
    private $encoderResolverMock;

    /**
      * @var MockObject|DecoderResolver
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

        $this->encoderResolverMock = $this->createEncoderResolverMock();
        $this->decoderResolverMock = $this->createDecoderResolverMock();

        $this->encoderMock = $this->encoderResolverMock->resolve('encode');
        $this->decoderMock = $this->decoderResolverMock->resolve('decode');

        $this->transcoderFactory = new TranscoderFactory(
            $this->decoderResolverMock,
            $this->encoderResolverMock,
            $this->logger
        );
    }

    public function testEncoderFactoryIsCalledWithEncoderType()
    {
        $expectedEncoder = 'encoder';

        $this->encoderResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with($expectedEncoder);

        $this->transcoderFactory->createTranscoder(null, $expectedEncoder);
    }

    public function testEncoderFactoryIsCalledWithDecoderType()
    {
        $expectedDecoder = 'decoder';

        $this->decoderResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with($expectedDecoder);

        $this->transcoderFactory->createTranscoder($expectedDecoder, null);
    }

    public function testPassThroughTranscoderIsCreatedForSameDecoderEncoder()
    {
        $expectedEncoder = $expectedDecoder = 'same';

        $this->encoderResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with(null);

        $this->decoderResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with(null);

        $this->transcoderFactory->createTranscoder($expectedDecoder, $expectedEncoder);
    }

    public function testTranscoderWasCreatedWithCreatedFactories()
    {
        $this->encoderMock
            ->expects($this->once())
            ->method('encode')
            ->withAnyParameters();

        $this->decoderMock
            ->expects($this->once())
            ->method('decode')
            ->withAnyParameters();

        $transcoder = $this->transcoderFactory->createTranscoder('decode', 'encode');

        $transcoder->transcode('data');
    }

    /**
     * @return MockObject
     */
    private function createLoggerMock()
    {
        return $this->getMockForAbstractClass('Symfony\Component\HttpKernel\Log\LoggerInterface');
    }

}
