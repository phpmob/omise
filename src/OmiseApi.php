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

namespace PhpMob\Omise;

use PhpMob\Omise\Client\HttpClientInterface;
use PhpMob\Omise\Hydrator\FacadeHydration;
use PhpMob\Omise\Hydrator\HydrationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class OmiseApi
{
    const VERSION = '1.0.0-beta1';
    const OMISE_ENDPOINT = 'https://api.omise.co/';
    const OMISE_VAULT_ENDPOINT = 'https://vault.omise.co/';
    const OMISE_VERSION = '2015-11-17';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var array
     */
    private $options;

    /**
     * @var HydrationInterface
     */
    private $hydration;

    /**
     * @var Api[]
     */
    private static $supports = [
        Facade\Account::class => Api\Account::class,
        Facade\Balance::class => Api\Balance::class,
        Facade\Charge::class => Api\Charge::class,
        Facade\Customer::class => Api\Customer::class,
        Facade\Dispute::class => Api\Dispute::class,
        Facade\Receipt::class => Api\Receipt::class,
        Facade\Recipient::class => Api\Recipient::class,
        Facade\Refund::class => Api\Refund::class,
        Facade\Token::class => Api\Token::class,
        Facade\Transaction::class => Api\Transaction::class,
        Facade\Transfer::class => Api\Transfer::class,
    ];

    /**
     * @param HttpClientInterface $httpClient
     * @param array $options
     * @param HydrationInterface $hydration
     */
    public function __construct(HttpClientInterface $httpClient, array $options, HydrationInterface $hydration = null)
    {
        $this->httpClient = $httpClient;
        $this->options = $options;
        $this->hydration = $hydration;
    }

    /**
     * @param $apiClass
     *
     * @return Api
     */
    public function create($apiClass)
    {
        if (!in_array(Api::class, class_parents($apiClass))) {
            throw new \LogicException("The api class ($apiClass) should have sub-type of " . Api::class);
        }

        return new $apiClass($this->httpClient, $this->options, $this->hydration);
    }

    /**
     * Static use setup.
     *
     * @param HttpClientInterface $httpClient
     * @param array $options
     */
    public static function setupFacade(HttpClientInterface $httpClient, array $options)
    {
        $self = new self($httpClient, $options, new FacadeHydration());

        /**
         * @var Facade $domainClass
         * @var Api $apiClass
         */
        foreach (self::$supports as $domainClass => $apiClass) {
            if (!in_array(Facade::class, class_parents($domainClass))) {
                throw new \LogicException("The domain class ($domainClass) should have sub-type of " . Facade::class);
            }

            $domainClass::setApi($self->create($apiClass));
        }
    }
}
