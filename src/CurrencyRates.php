<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 10/11/2016
 * Time: 4:07 PM
 */

namespace naffiq\tenge;


use LaLit\XML2Array;

/**
 * Class CurrencyRates
 * @package naffiq\tenge
 */
class CurrencyRates
{
    // Ссылка на все валюты
    const URL_RATES_ALL = "http://www.nationalbank.kz/rss/rates_all.xml";
    // Ссылка на основные валюты
    const URL_RATES_MAIN = "http://www.nationalbank.kz/rss/rates.xml";

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
     */
    public function __construct($url = self::URL_RATES_MAIN)
    {
        $this->url = $url;
        $data = self::getRates();

        foreach ($data['rss']['channel']['item'] as $currencyRate) {
            $currencyTitle = strtoupper($currencyRate['title']);
            $this->_rates[$currencyRate['title']] = Currency::fromArray($currencyRate);
        }
    }

    /**
     * Метод для конвертации валюты в тенге
     *
     * @param string    $currencyCode   код валюты
     * @param int       $quantity       кол-во переводимой валюты
     * @param bool      $buy            если выставлено true, то возвращает цену покупки валюты банком
     *
     * @return double
     * @throws \Exception
     */
    public function convertToTenge($currencyCode, $quantity = 1, $buy = false)
    {
        return $this->convert($currencyCode, $quantity, $buy);
    }

    /**
     * Метод для конвертации валюты из тенге
     *
     * @param string    $currencyCode   код валюты
     * @param int       $quantity       кол-во переводимой валюты
     * @param bool      $buy            если выставлено true, то возвращает цену покупки валюты банком
     *
     * @return float
     * @throws \Exception
     */
    public function convertFromTenge($currencyCode, $quantity = 1, $buy = false)
    {
        return $this->convert($currencyCode, $quantity, $buy, true);
    }

    /**
     * Внутренний метод перевода валют с проверкой входных данных
     *
     * @param string    $currencyCode   код валюты
     * @param int       $quantity       кол-во переводимой валюты
     * @param bool      $buy            если выставлено true, то возвращает цену покупки валюты банком
     * @param bool      $from           при указанном параметре true, осуществляет конвертацию из тенге
     *
     * @return float
     * @throws \Exception
     */
    private function convert($currencyCode, $quantity = 1, $buy = false, $from = false)
    {
        $currencyCode = strtoupper($currencyCode);

        // Т.к. Нацбанк Казахстана использует устаревший код RUR, проверяем
        if ($currencyCode == 'RUB' && !empty($this->_rates['RUR'])) $currencyCode = 'RUR';

        if (!empty($this->_rates[$currencyCode])) {
            if ($from) {
                $result = $this->_rates[$currencyCode]->convertFromTenge($quantity, $buy);
            } else {
                $result = $this->_rates[$currencyCode]->convertToTenge($quantity, $buy);
            }

            return (float) number_format($result, 2);
        }

        throw new \Exception('Undefined currency code');
    }

    /**
     * Конвертирует XML с курсом валют в массив
     *
     * @return array
     */
    private function getRates()
    {
        $data = file_get_contents($this->url);

        $xmlData = XML2Array::createArray($data);
        return $xmlData;
    }
}
