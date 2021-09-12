<?php

namespace ClickUp\Objects;

use ClickUp\Client;

/**
 * @method Task   getByKey(string $id)
 * @method Task   getByName(string $name)
 * @method Task[] objects()
 * @method Task[] getIterator()
 * @method Task   getByTaskId(string|null $parentTaskId)
 */
class TaskCollection extends AbstractObjectCollection
{
    public function __construct(Client $client, $array, $teamId)
    {
        parent::__construct($client, $array);

        if (!empty($this->objects)) {
            foreach ($this as $task) {
                $task->setTeamId($teamId);
            }
        }
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return Task::class;
    }
}
