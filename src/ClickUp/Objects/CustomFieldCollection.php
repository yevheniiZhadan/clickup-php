<?php

namespace ClickUp\Objects;

/**
 * @method CustomField   getByKey(int string $id)
 * @method CustomField   getByName(string string $name)
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
