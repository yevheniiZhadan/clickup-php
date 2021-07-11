<?php

namespace ClickUp\Objects;

/**
 * @method Comment   getByKey(int $commentId)
 * @method Comment[] objects()
 * @method Comment[] getIterator()
 */
class CommentCollection extends AbstractObjectCollection
{
    /**
     * @return string
     */
    protected function objectClass()
    {
        return Comment::class;
    }
}
