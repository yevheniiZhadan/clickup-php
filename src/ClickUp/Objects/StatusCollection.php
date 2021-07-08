<?php

namespace ClickUp\Objects;

/**
 * @method Status   getByKey(int $orderindex)
 * @method Status   getByName(string $statusName)
 * @method Status[] objects()
 * @method Status[] getIterator()
 */
class StatusCollection extends AbstractObjectCollection
{
    public function key()
    {
        return 'orderindex';
    }

    /**
     * @return string
     */
    protected function objectClass()
    {
        return Status::class;
    }
}
