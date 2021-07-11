<?php

namespace ClickUp\Objects;

/**
 * @method Tag   getByKey(int $tagId)
 * @method Tag   getByName(string $tagName)
 * @method Tag[] objects()
 * @method Tag[] getIterator()
 */
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
