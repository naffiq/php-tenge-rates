# Курсы валют от Нацбанка Казахстана
[![PHP version](https://badge.fury.io/ph/naffiq%2Fphp-tenge-rates.svg)](https://badge.fury.io/ph/naffiq%2Fphp-tenge-rates)
[![Travis CI build](https://api.travis-ci.org/naffiq/php-tenge-rates.svg?branch=master "Travis CI build")](https://travis-ci.org/naffiq/php-tenge-rates)

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

$rates = new \naffiq\tenge\CurrencyRates();
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

// При передаче аргумента true, обрабатывается второй источник нацбанка
$rates = new \naffiq\tenge\CurrencyRates(true);
echo $rates->convertToTenge('GBP', 100); // 41242 на момент написания примера
```

Возможные коды валют
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
