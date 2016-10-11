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
    public function __construct($data)
    {
        $this->title = $data['title'];
        $this->pubDate = $data['pubDate'];
        $this->buyRate = (double) $data['description'];
        $this->sellRate = $this->buyRate + (double) $data['change'];
        $this->index = $data['index'];
        $this->quantity = (int) $data['quant'];
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