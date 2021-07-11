<?php

namespace ClickUp\Objects;

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
