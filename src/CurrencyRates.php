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

    private $all = false;

    /**
     * @var Currency[]
     */
    private $_rates = [];

    /**
     * CurrencyRates constructor.
     *
     * @param bool $all
     */
    public function __construct($all = false)
    {
        $this->all = $all;
        $data = self::getRates($all);

        foreach ($data['rss']['channel']['item'] as $currencyRate) {
            $currencyTitle = strtoupper($currencyRate['title']);
            $this->_rates[$currencyRate['title']] = new Currency($currencyRate);
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
        if ($currencyCode == 'RUB' && !$this->all) $currencyCode = 'RUR';

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
     * Возвращает XML с курсом валют
     *
     * @param $all bool При значении `false` получит курсы только для рубля, доллара и евро
     *
     * @return string
     */
    private static function getRates($all = false)
    {
        $data = file_get_contents($all ? self::URL_RATES_ALL : self::URL_RATES_MAIN);

        $xmlData = XML2Array::createArray($data);
        return $xmlData;
    }
}
