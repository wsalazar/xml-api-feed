<?php

namespace App\Services;


class ArraySort
{
    private $list = [];

    private $service;

    /**
     * @param ConsumeServices $service
     * @param array $array
     */
    public function __construct(ConsumeServices $service, array $array = [])
    {
        $this->service = $service;
        $this->list = $array;
    }

    /**
     * @return $this
     */
    public final function sortAscending(): ArraySort
    {
        $this->list = $this->usort($this->list);

        return $this;
    }

    /**
     * @param array $array
     * @return array
     */
    public final function usort(array $array): array
    {
        return $this->service->sort($array);
    }

    /**
     * @return array
     */
    public function reverseSort(): array
    {
        return array_reverse($this->list);
    }

}