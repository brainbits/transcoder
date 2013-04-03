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

use Assert\Assertion;

/**
 * 7z decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class SevenzDecoder implements DecoderInterface
{
    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        $process = proc_open(
            '7z e -an -txz -m0=lzma2 -mx=9 -mfb=64 -md=32m -si -so',
            [ ['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w'] ],
            $pipes,
            null,
            null
        );

        if (strlen($data)) {
            if (is_resource($process)) {
                fwrite($pipes[0], $data);
                fclose($pipes[0]);
                $data = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $errors = stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                $return_value = proc_close($process);
            }

            Assertion::minLength($data, 1, '7z returned no data');
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return '7z' === $type;
    }
}
