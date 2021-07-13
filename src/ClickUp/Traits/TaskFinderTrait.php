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
     * @param callable|null $callback
     *
     * @return bool
     */
    public function tasksChunk($includeSubTask = false, $includeClosed = false, $callback = null)
    {
        $page = 0;

        do {
            $tasks = null;
            try {
                $tasks = $this
                    ->taskFinder()
                    ->includeSubTask($includeSubTask)
                    ->includeClosed($includeClosed)
                    ->addParams(['page' => $page])
                    ->getCollection();

                $issetTasks = $tasks->isNotEmpty();
                $tasks = $tasks->objects();
            } catch (Exception $exception) { }

            if(empty($issetTasks)) {
                break;
            }

            if($callback == null || $callback($tasks) == false) {
                return false;
            }

            unset($tasks);
            $page++;
        } while (true);

        return true;
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
