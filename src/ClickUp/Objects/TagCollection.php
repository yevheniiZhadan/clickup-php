<?php

namespace ClickUp\Objects;

class TagCollection extends AbstractObjectCollection
{
    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $i = 0;
        foreach ($array as $key => $tag) {
            $array[$key]['id'] = $i++;
        }

        parent::fromArray($array);
    }

    /**
     * @return string
     */
    protected function objectClass()
    {
        return Tag::class;
    }
}
