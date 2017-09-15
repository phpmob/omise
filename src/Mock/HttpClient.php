<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Mock;

use GuzzleHttp\Psr7\Response;
use PhpMob\Omise\Client\HttpClientInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $status = 200;

    /**
     * {@inheritdoc}
     */
    public function send($method, $uri, array $data = [], array $headers = [])
    {
        return new Response($this->status, $this->headers, $this->content);
    }

    /**
     * @param string $contentFileName
     *
     * @return $this
     */
    public function fixture($contentFileName)
    {
        $this->content = Fixture::get($contentFileName);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param integer $status
     *
     * @return $this
     */
    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function headers(array $headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function header($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @return HttpClient
     */
    public static function make()
    {
        return new self();
    }
}
