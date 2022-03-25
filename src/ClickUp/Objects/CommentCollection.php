<?php

namespace ClickUp\Objects;

/**
 * @method Comment   getByKey(int $id)
 * @method Comment[] objects()
 * @method Comment[] getIterator()
 */
class CommentCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return Comment::class;
    }
}
