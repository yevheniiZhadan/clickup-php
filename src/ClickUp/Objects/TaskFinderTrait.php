<?php

namespace ClickUp\Objects;

use ClickUp\Client;

trait TaskFinderTrait
{
    /**
     * @param bool $includeSubTask
     * @param bool $includeClosed
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
     * @param int $taskId
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
