<?php

namespace ClickUp\Traits;

use DateTimeImmutable;
use Exception;

/**
 * Trait DateImmutableTrait
 *
 * @package ClickUp\Traits
 */
trait DateImmutableTrait
{
    /**
     * @param $array
     * @param $key
     *
     * @return DateTimeImmutable|null
     * @throws Exception
     */
    private function getDate($array, $key): ?DateTimeImmutable
    {
        if (!isset($array[$key])) {
            return null;
        }
        $unixTime = substr($array[$key], 0, 10);
        return new DateTimeImmutable("@$unixTime");
    }

    /**
     * @return float
     */
    private function getCurrentDate(): float
    {
        return round(microtime(true) * 1000);
    }
}
