# Курсы валют от Нацбанка Казахстана

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

$rates = new \naffiq\tenge\CurrencyRates(true); // При передаче аргумента true, обрабатывается второй источник нацбанка
echo $rates->convertToTenge('GBP', 100); // 41242 на момент написания примера
```
