<?php

namespace ClickUp\Objects;

use ClickUp\Client;

/**
 * @method Task   getByKey(int $spaceId)
 * @method Task   getByName(string $spaceName)
 * @method Task[] objects()
 * @method Task[] getIterator()
 * @method Task   getByTaskId(string|null $parentTaskId)
 */
class TaskCollection extends AbstractObjectCollection
{
    public function __construct(Client $client, $array, $teamId)
    {
        parent::__construct($client, $array);
        foreach ($this as $task) {
            $task->setTeamId($teamId);
        }
    }

    /**
     * @return string
     */
    protected function objectClass()
    {
        return Task::class;
    }
}
