<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Encoder;

/**
 * Encoder resolver interface
 * Resolves decoders based on supported type
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 */
interface EncoderResolverInterface
{
    /**
     * @param string|null $type
     * @return EncoderInterface
     */
    public function resolve($type);
}
