# Курсы валют от Нацбанка Казахстана
[![PHP version](https://badge.fury.io/ph/naffiq%2Fphp-tenge-rates.svg)](https://badge.fury.io/ph/naffiq%2Fphp-tenge-rates)
[![Travis CI build](https://api.travis-ci.org/naffiq/php-tenge-rates.svg?branch=master "Travis CI build")](https://travis-ci.org/naffiq/php-tenge-rates)
[![Code Climate](https://codeclimate.com/github/naffiq/php-tenge-rates/badges/gpa.svg)](https://codeclimate.com/github/naffiq/php-tenge-rates)
[![Test Coverage](https://codeclimate.com/github/naffiq/php-tenge-rates/badges/coverage.svg)](https://codeclimate.com/github/naffiq/php-tenge-rates/coverage)
[![Issue Count](https://codeclimate.com/github/naffiq/php-tenge-rates/badges/issue_count.svg)](https://codeclimate.com/github/naffiq/php-tenge-rates)

Данный компонент является оберткой для обработки курса от Нацбанка.

Актуальный курс доступен по ссылке http://www.nationalbank.kz/rss/rates.xml

## Установка

Предпочтительный способ установки - через composer

```bash
$ composer require naffiq/php-tenge-rates
```

## Использование

```php
<?php

require __DIR__ . '/vendor/autoload.php';
use naffiq\tenge\CurrencyRates;
$rates = new CurrencyRates();
echo $rates->convertToTenge('USD', 100); // 33214 на момент написания примера
```

Возможные коды валют:
* USD
* RUR
* EUR

### Больше видов валют

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use naffiq\tenge\CurrencyRatecs;
// URL для всех валют содержится в качестве константы в классе CurrencyRates
$rates = new CurrencyRates(CurrencyRates::URL_RATES_ALL);
echo $rates->convertToTenge('GBP', 100); // 41242 на момент написания примера
```

Все возможные коды валют:
* AUD
* GBP
* DKK
* AED
* USD
* EUR
* CAD
* CNY
* KWD
* KGS
* LVL
* MDL
* NOK
* SAR
* RUB
* XDR
* SGD
* TRL
* UZS
* UAH
* SEK
* CHF
* EEK
* KRW
* JPY
* BYN
* PLN
* ZAR
* TRY
* HUF
* CZK
* TJS
* HKD
* BRL
* MYR
* AZN
* INR
* THB
* AMD
* GEL
* IRR
* MXN

## Прохождение по валютам
Ниже предоставлен пример кода для прохождения по всем валютам. 
Класс `\naffiq\tenge\CurrencyRates` имлементирует интерфейсы `\Countable` и `\IteratorAggregate`,
так что с его объектами можно орудовать как с массивами. 

```php
<?php

require __DIR__ . '/vendor/autoload.php';
use naffiq\tenge\CurrencyRates;
$rates = new CurrencyRates();

foreach ($rates as $rate) {
    /**
     * @var \naffiq\tenge\Currency $rate 
     */
    echo "{$rate->title} - {$rate->price}";
}
```