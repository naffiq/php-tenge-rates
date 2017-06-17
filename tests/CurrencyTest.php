<?php

/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 6/17/2017
 * Time: 9:36 PM
 */

use naffiq\tenge\Currency;

class CurrencyTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialization()
    {
        // This array is copied from XML
        $ruble = Currency::fromArray([
            'title' => 'RUR',
            'pubDate' => '16.06.17',
            'description' => '5.53',
            'quant' => '1',
            'index' => 'DOWN',
            'change' => '-0.01',
            'link' => ''
        ]);

        $this->assertTrue($ruble instanceof Currency);
    }

    public function testConvertToTenge()
    {
        $ruble = new Currency('RUR', '16.06.17', 5.53, -0.01, 'DOWN', 1, '');

        $this->assertEquals(11.06, $ruble->toTenge(2));
    }

    public function testConvertFromTenge()
    {
        $ruble = new Currency('RUR', '16.06.17', 5.53, -0.01, 'DOWN', 1, '');

        $this->assertEquals(3, $ruble->fromTenge(16.59));
    }

    public function testIsFresh()
    {
        $ruble = new Currency('RUR', '16.06.17', 5.53, -0.01, 'DOWN', 1, '');

        $this->assertFalse($ruble->isFresh());
    }
}