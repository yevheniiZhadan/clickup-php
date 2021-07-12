<?php

namespace ClickUp\Traits;

use ClickUp\Client;
use ClickUp\Objects\Task;
use ClickUp\Objects\TaskCollection;
use ClickUp\Objects\TaskFinder;
use Exception;

/**
 * Trait TaskFinderTrait
 * @package ClickUp\Traits
 */
trait TaskFinderTrait
{
    /**
     * @param bool $includeSubTask
     * @param bool $includeClosed
     *
     * @return TaskCollection
     */
    public function tasks($includeSubTask = false, $includeClosed = false)
    {
        return $this
            ->taskFinder()
            ->includeSubTask($includeSubTask)
            ->includeClosed($includeClosed)
            ->getCollection();
    }

    /**
     * @param false $includeSubTask
     * @param false $includeClosed
     * @param array $prevTasks
     * @param int $pageIndex
     *
     * @return array
     */
    public function tasksAll($includeSubTask = false, $includeClosed = false, $prevTasks = [], $pageIndex = 1)
    {
        $tasks = [];
        try {
            $tasks = $this
                ->taskFinder()
                ->includeSubTask($includeSubTask)
                ->includeClosed($includeClosed)
                ->addParams(['page' => $pageIndex++])
                ->getCollection()
                ->objects();
        } catch (Exception $exception) { }

        if(!empty($tasks)) {
            $tasks = $this->tasksAll($includeSubTask, $includeClosed, $tasks, $pageIndex);
        }

        return array_merge($prevTasks, $tasks);
    }

    /**
     * @param int $taskId
     *
     * @return Task
     */
    public function task($taskId)
    {
        return $this->taskFinder()->getByTaskId($taskId);
    }

    /**
     * @return TaskFinder
     */
    public function taskFinder()
    {
        return (new TaskFinder(
            $this->client(),
            $this->teamId()
        ))->addParams($this->taskFindParams());
    }

    /**
     * @return Client
     */
    abstract public function client();

    /**
     * @return int
     */
    abstract public function teamId();

    /**
     * @return array
     */
    protected function taskFindParams()
    {
        return [];
    }
}
