<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\Omise\Client;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\HttpClient;
use PhpMob\Omise\OmiseApi;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->httpClient = GuzzleAdapter::createWithConfig(
            array_replace_recursive(
                [
                    'verify' => true,
                    'headers' => [
                        'User-Agent' => 'PHPMOB-OMISE/' . OmiseApi::VERSION,
                    ],
                ],
                $config
            )
        );
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function send($method, $uri, array $data = [], array $headers = [])
    {
        if ('GET' === strtoupper($method) && !empty($data)) {
            $uri = $uri . '?' . http_build_query($data);
            $data = [];
        }

        return $this->httpClient->sendRequest(
            new Request($method, $uri, $headers, \GuzzleHttp\json_encode($data))
        );
    }
}
