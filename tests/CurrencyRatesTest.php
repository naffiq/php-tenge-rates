<?php

/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 6/16/17
 * Time: 16:30
 */

use naffiq\tenge\CurrencyRates;

class CurrencyRatesTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialization()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');

        $this->assertNotEmpty($rates->convertToTenge('RUB'));
    }

    public function testRSSAvailability()
    {
        $rates = new CurrencyRates();

        $this->assertNotEmpty($rates->convertToTenge('RUB'));
    }
}