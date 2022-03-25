<?php

namespace ClickUp\Objects;

/**
 * @method Team   getByKey(int $id)
 * @method Team   getByName(string $name)
 * @method Team[] objects()
 * @method Team[] getIterator()
 */
class TeamCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return Team::class;
    }
}
