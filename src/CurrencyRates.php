<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 10/11/2016
 * Time: 4:07 PM
 */

namespace naffiq\tenge;


use LaLit\XML2Array;
use Traversable;

/**
 * Class CurrencyRates
 * @package naffiq\tenge
 */
class CurrencyRates implements \IteratorAggregate, \Countable
{
    // Ссылка на все валюты
    const URL_RATES_ALL = "http://old.nationalbank.kz/rss/rates_all.xml";
    // Ссылка на основные валюты
    const URL_RATES_MAIN = "http://old.nationalbank.kz/rss/rates.xml";

    /**
     * @var string Ссылка на API Национального Банка Казахстана
     */
    private $url = self::URL_RATES_MAIN;

    /**
     * @var Currency[]
     */
    private $_rates = [];

    /**
     * CurrencyRates constructor.
     *
     * @param string $url
     * @param int $timeout Timeout for getting currency data
     */
    public function __construct($url = self::URL_RATES_MAIN, $timeout = 1)
    {
        $this->url = $url;
        $data = self::getRates($timeout);

        foreach ($data['rss']['channel']['item'] as $currencyRate) {
            $currencyTitle = strtoupper($currencyRate['title']);
            $this->_rates[$currencyTitle] = Currency::fromArray($currencyRate);
        }
    }

    /**
     * Метод для конвертации валюты в тенге
     *
     * @param string    $currencyCode   код валюты
     * @param int       $quantity       кол-во переводимой валюты
     *
     * @return double
     * @throws \Exception
     */
    public function convertToTenge($currencyCode, $quantity = 1)
    {
        return $this->getCurrency($currencyCode)->toTenge($quantity);
    }

    /**
     * Метод для конвертации валюты из тенге
     *
     * @param string    $currencyCode   код валюты
     * @param int       $quantity       кол-во переводимой валюты
     *
     * @return float
     * @throws \Exception
     */
    public function convertFromTenge($currencyCode, $quantity = 1)
    {
        return $this->getCurrency($currencyCode)->fromTenge($quantity);
    }

    /**
     * Поиск валюты по коду
     *
     * @param string $currencyCode
     * @return Currency
     * @throws \Exception
     */
    public function getCurrency($currencyCode)
    {
        $currencyCode = strtoupper($currencyCode);

        // Т.к. Нацбанк Казахстана использует устаревший код RUR, проверяем
        if ($currencyCode == 'RUB' && !empty($this->_rates['RUR'])) $currencyCode = 'RUR';

        if (!empty($this->_rates[$currencyCode])) {
           return $this->_rates[$currencyCode];
        }

        throw new \Exception('Undefined currency code');
    }

    /**
     * Конвертирует XML с курсом валют в массив
     *
     * @return array
     */
    private function getRates($timeout = 1)
    {
        $options = stream_context_create(['http'=> ['timeout' => $timeout]]);
        $data = file_get_contents($this->url, false, $options);

        $xmlData = XML2Array::createArray($data);
        return $xmlData;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_rates);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->_rates);
    }
}
