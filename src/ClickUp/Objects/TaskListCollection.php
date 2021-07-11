<?php

namespace ClickUp\Objects;

/**
 * @method TaskList   getByKey(int $listId)
 * @method TaskList   getByName(string $listName)
 * @method TaskList[] objects()
 * @method TaskList[] getIterator()
 */
class TaskListCollection extends AbstractObjectCollection
{
    public function __construct(Folder $project, $array)
    {
        parent::__construct($project->client(), $array);
        foreach ($this as $taskList) {
            $taskList->setFolder($project);
        }
    }

    /**
     * @return string
     */
    protected function objectClass()
    {
        return TaskList::class;
    }
}
