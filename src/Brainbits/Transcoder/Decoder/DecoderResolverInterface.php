<?php
/**
 * This file is part of the brainbits transcoder package.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

/**
 * Decoder resolver interface
 * Resolves decoders based on supported type
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 */
interface DecoderResolverInterface
{
    /**
     * @param string|null $type
     * @return DecoderInterface
     */
    public function resolve($type);
}
