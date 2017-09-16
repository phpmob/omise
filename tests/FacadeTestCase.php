<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\PhpMob\Omise;

use PhpMob\Omise\OmiseApi;
use PHPUnit\Framework\TestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FacadeTestCase extends TestCase
{
    protected $chargeId = 'chrg_test_5086xlsx4lghk9bpb75';
    protected $customerId = 'cust_test_5086xleuh9ft4bn0ac2';
    protected $tokenId = 'tokn_test_5086xl7c9k5rnx35qba';

    /**
     * @var HttpClient
     */
    protected $client;

    public function setUp()
    {
        $this->client = new HttpClient();
        $options = [
            'secret_key' => 'your_secret_key',
            'public_key' => 'your_public_key',
            'sandbox' => true,
        ];

        OmiseApi::setupFacade($this->client, $options);
    }

    public function tearDown()
    {
        $this->client = null;
    }
}
