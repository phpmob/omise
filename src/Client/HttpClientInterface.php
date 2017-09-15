<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Client;

use Psr\Http\Message\ResponseInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function send($method, $uri, array $data = [], array $headers = []);
}
