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
     * @var float
     */
    public $price;

    /**
     * @var float
     */
    public $change;

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
     * @param string $title Название валюты
     * @param string $pubDate
     * @param float $price
     * @param float $change
     * @param int $index
     * @param int $quantity
     */
    public function __construct($title, $pubDate, $price, $change, $index, $quantity)
    {
        $this->title = $title;
        $this->pubDate = $pubDate;
        $this->price = $price;
        $this->change = $change;
        $this->index = $index;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data)
    {
        return new static($data['title'], $data['pubDate'], (double)$data['description'], (double)$data['change'], $data['index'], (int)$data['quant']);
    }

    /**
     * @param $quantity
     *
     * @return double
     */
    public function toTenge($quantity)
    {
        return $quantity * $this->price / $this->quantity;
    }

    /**
     * @param $quantity
     * @return float
     */
    public function fromTenge($quantity)
    {
        return $quantity / $this->price * $this->quantity;
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