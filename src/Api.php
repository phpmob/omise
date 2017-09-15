<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise;

use PhpMob\Omise\Client\HttpClientInterface;
use PhpMob\Omise\Exception\InvalidRequestArgumentException;
use PhpMob\Omise\Exception\InvalidResponseException;
use PhpMob\Omise\Domain\Error;
use PhpMob\Omise\Hydrator\Hydration;
use PhpMob\Omise\Hydrator\HydrationInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class Api
{
    /**
     * @var bool
     */
    protected $isSensitive = false;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var HydrationInterface
     */
    private $hydration;

    /**
     * @param HttpClientInterface $httpClient
     * @param array $options
     * @param HydrationInterface $hydration
     */
    public function __construct(HttpClientInterface $httpClient, array $options, HydrationInterface $hydration = null)
    {
        $this->httpClient = $httpClient;

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
        $this->hydration = $hydration ?: new Hydration();
        $this->isSensitive = $this->options['sensitive'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['secret_key', 'public_key', 'sandbox']);

        $resolver->setAllowedTypes('secret_key', 'string');
        $resolver->setAllowedTypes('public_key', 'string');
        $resolver->setAllowedTypes('sandbox', 'boolean');

        $resolver->setDefault('sensitive', $this->isSensitive);
    }

    /**
     * @return string
     */
    protected function getAuthorizationKey()
    {
        return 'Basic '.base64_encode($this->options[$this->isSensitive ? 'public_key' : 'secret_key'].':');
    }

    /**
     * @return string
     */
    protected function getApiServer()
    {
        return $this->isSensitive ? OmiseApi::OMISE_VAULT_ENDPOINT : OmiseApi::OMISE_ENDPOINT;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $data
     * @param array $headers
     *
     * @return mixed|Model
     * @throws InvalidResponseException
     */
    protected function doRequest($method, $path, array $data = [], array $headers = [])
    {
        $headers = array_merge(['Authorization' => $this->getAuthorizationKey()], $headers);

        if ('GET' !== strtoupper($method)) {
            $data = array_merge($data, ['livemode' => $this->options['sandbox']]);
            $headers = array_merge(['Content-Type' => 'application/json; charset=utf-8'], $headers);
        }

        $uri = preg_replace('/([^:])(\/{2,})/', '$1/', $this->getApiServer().$path);
        $response = $this->httpClient->send($method, $uri, $data, $headers);

        return $this->hydrateResponse($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed|Model
     * @throws InvalidResponseException
     */
    protected function hydrateResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        // non api error, mock server error.
        if (empty($content) && $response->getStatusCode() >= 400) {
            $content = json_encode(
                [
                    'object' => 'error',
                    'code' => 'HTTP-'.$response->getStatusCode(),
                    'message' => $response->getReasonPhrase(),
                ]
            );
        }

        $result = $this->hydration->hydrate($content);

        if ($result instanceof Error) {
            throw new InvalidResponseException($result);
        }

        return $result;
    }

    /**
     * @param string $id
     * @param string $message
     *
     * @throws InvalidRequestArgumentException
     */
    protected static function assertNotEmpty($id, $message = 'Id can not be empty.')
    {
        if (empty($id)) {
            throw new InvalidRequestArgumentException($message);
        }
    }
}
