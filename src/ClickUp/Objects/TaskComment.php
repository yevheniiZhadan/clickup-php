<?php

namespace ClickUp\Objects;

/**
 * Class TaskComment
 *
 * @package ClickUp\Objects
 */
class TaskComment extends Comment
{
    /** @var Task */
    private $task;

    /**
     * @return Task
     */
    public function task(): Task
    {
        return $this->task;
    }

    /**
     * @param  Task  $task
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
    }
}
