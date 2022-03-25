<?php

namespace ClickUp\Objects;

/**
 * @method CustomField   getByKey(int $id)
 * @method CustomField   getByName(string $name)
 * @method CustomField[] objects()
 * @method CustomField[] getIterator()
 */
class CustomFieldCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return CustomField::class;
    }
}
