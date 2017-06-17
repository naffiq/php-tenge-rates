<?php

/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 6/16/17
 * Time: 16:30
 */

use naffiq\tenge\CurrencyRates;
use naffiq\tenge\Currency;

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

    public function testRSSAllAvailability()
    {
        $rates = new CurrencyRates(CurrencyRates::URL_RATES_ALL);

        $this->assertNotEmpty($rates->convertToTenge('RUB'));
    }

    public function testGetRates()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');

        $this->assertNotEmpty($rates->getCurrency('RUB'));
        $this->assertNotEmpty($rates->getCurrency('RUR'));
    }

    public function testConvertToTenge()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');

        $this->assertEquals(5.53, $rates->convertToTenge('RUR'));
    }

    public function testConvertFromTenge()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');

        $this->assertEquals(3, $rates->convertFromTenge('RUR', 16.59));
    }

    public function testCountable()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');
        $this->assertEquals(3, count($rates));
    }

    public function testIteratorAggregate()
    {
        $rates = new CurrencyRates(__DIR__ . '/data/sample.xml');
        foreach ($rates as $rate) {
            $this->assertTrue($rate instanceof Currency);
        }
    }
}