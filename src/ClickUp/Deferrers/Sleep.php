<?php

namespace ClickUp\Deferrers;

/**
 * Class Sleep
 * @package ClickUp\Deferrers
 */
class Sleep implements \ClickUp\Contracts\TimeDeferrer
{
    /**
     * @inheritDoc
     */
    public function getCurrentTime()
    {
        return microtime(true) * 1000000;
    }

    /**
     * @inheritDoc
     */
    public function sleep(float $microseconds)
    {
        usleep((int) $microseconds);
    }
}