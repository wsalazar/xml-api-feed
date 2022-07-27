<?php

namespace App\Services;


class ArraySort
{
    private $list = [];

    /**
     * @param $array
     * @param $flags
     */
    public function __construct(array $array = [])
    {
        $this->list = $array;
    }

    /**
     * @return $this
     */
    public function sortAscending(): ArraySort
    {
        $this->list = $this->usort($this->list);

        return $this;
    }

    /**
     * @param array $array
     * @return array
     */
    public final function usort(array $array):array
    {
        usort($array, function($var1, $var2) {
            return strcmp($var1['person']['fullName']['last'], $var2['person']['fullName']['last']);
        });
        return $array;
    }

    /**
     * @return array
     */
    public function reverseSort(): array
    {
        return array_reverse($this->list);
    }

}