<?php

namespace ClickUp\Objects;

/**
 * @method User   getById(int $id)
 * @method User   getByName(string $name)
 * @method User[] objects()
 * @method User[] getIterator()
 */
class UserCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function nameKey(): string
    {
        return 'username';
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return User::class;
    }
}
