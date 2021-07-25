<?php

namespace ClickUp\Objects;

/**
 * @method Status   getByKey(int int $id)
 * @method Status   getByName(string string $name)
 * @method Status[] objects()
 * @method Status[] getIterator()
 */
class StatusCollection extends AbstractObjectCollection
{
    public function key(): string
    {
        return 'orderindex';
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return Status::class;
    }
}
