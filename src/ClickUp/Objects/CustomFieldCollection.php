<?php

namespace ClickUp\Objects;

/**
 * @method CustomField   getByKey(string $fieldId)
 * @method CustomField   getByName(string $fieldName)
 * @method CustomField[] objects()
 * @method CustomField[] getIterator()
 */
class CustomFieldCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function objectClass()
    {
        return CustomField::class;
    }
}
