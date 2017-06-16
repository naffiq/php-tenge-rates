<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 10/11/2016
 * Time: 4:09 PM
 */

namespace naffiq\tenge;

/**
 * Class Currency
 *
 * Реализует конвертацию для каждой конкретной валюты
 *
 * @package naffiq\tenge
 */
class Currency
{
    /**
     * @var string Код валюты
     */
    public $title;
    /**
     * @var string Дата
     */
    public $pubDate;

    /**
     * @var double
     */
    public $sellRate;

    /**
     * @var double
     */
    public $buyRate;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $index;

    /**
     * Currency constructor.
     * @param $data
     */
    public function __construct($title, $pubDate, $buyRate, $sellRate, $index, $quantity)
    {
        $this->title = $title;
        $this->pubDate = $pubDate;
        $this->buyRate = $buyRate;
        $this->sellRate = $sellRate;
        $this->index = $index;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data)
    {
        return new static($data['title'], $data['pubDate'], (double)$data['description'], (double)$data['description'] + (double)$data['change'], $data['index'], (int)$data['quant']);
    }

    /**
     * @param $quantity
     * @param bool $buy
     *
     * @return double
     */
    public function convertToTenge($quantity, $buy = false)
    {
        return $quantity * ($buy ? $this->buyRate : $this->sellRate) / $this->quantity;
    }

    /**
     * @param $quantity
     * @param bool $buy
     * @return float
     */
    public function convertFromTenge($quantity, $buy = false)
    {
        return $quantity / ($buy ? $this->buyRate : $this->sellRate) * $this->quantity;
    }

    /**
     * Проверяет, актуален ли текущий курс
     *
     * @return bool
     */
    public function isFresh()
    {
        return $this->pubDate == date('d.m.y');
    }
}