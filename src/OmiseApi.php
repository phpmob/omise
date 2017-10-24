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

use PhpMob\Omise\Api\Account as AccountApi;
use PhpMob\Omise\Api\Balance as BalanceApi;
use PhpMob\Omise\Api\Charge as ChargeApi;
use PhpMob\Omise\Api\Customer as CustomerApi;
use PhpMob\Omise\Api\Dispute as DisputeApi;
use PhpMob\Omise\Api\Receipt as ReceiptApi;
use PhpMob\Omise\Api\Recipient as RecipientApi;
use PhpMob\Omise\Api\Refund as RefundApi;
use PhpMob\Omise\Api\Token as TokenApi;
use PhpMob\Omise\Api\Transaction as TransactionApi;
use PhpMob\Omise\Api\Transfer as TransferApi;
use PhpMob\Omise\Client\HttpClientInterface;
use PhpMob\Omise\Facade\Account;
use PhpMob\Omise\Facade\Balance;
use PhpMob\Omise\Facade\Charge;
use PhpMob\Omise\Facade\Customer;
use PhpMob\Omise\Facade\Dispute;
use PhpMob\Omise\Facade\Receipt;
use PhpMob\Omise\Facade\Recipient;
use PhpMob\Omise\Facade\Refund;
use PhpMob\Omise\Facade\Token;
use PhpMob\Omise\Facade\Transaction;
use PhpMob\Omise\Facade\Transfer;
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
     * @var array
     */
    private static $supports = [
        Account::class => AccountApi::class,
        Balance::class => BalanceApi::class,
        Charge::class => ChargeApi::class,
        Customer::class => CustomerApi::class,
        Dispute::class => DisputeApi::class,
        Receipt::class => ReceiptApi::class,
        Recipient::class => RecipientApi::class,
        Refund::class => RefundApi::class,
        Token::class => TokenApi::class,
        Transaction::class => TransactionApi::class,
        Transfer::class => TransferApi::class,
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
         * @var Facade
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
