<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;

/**
 * Class Folder
 * @package ClickUp\Objects
 */
class Folder extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /** @var int $orderIndex */
    private $orderIndex;

    /** @var bool $isHidden */
    private $isHidden;

    /** @var string $taskCount */
    private $taskCount;

    /* @var TaskListCollection $taskLists */
    private $taskLists;

    /* @var bool $overrideStatuses */
    private $overrideStatuses;

    /* @var StatusCollection|null $statuses */
    private $statuses = null;

    /* @var int $spaceId */
    private $spaceId;

    /* @var Space $space */
    private $space;

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function orderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->isHidden;
    }

    /**
     * @return string
     */
    public function taskCount()
    {
        return $this->taskCount;
    }

    /**
     * @param int $taskListId
     * @return TaskList
     */
    public function taskList($taskListId)
    {
        return $this->taskLists()->getByKey($taskListId);
    }

    /**
     * @return TaskListCollection
     */
    public function taskLists()
    {
        return $this->taskLists;
    }

    /**
     * @return bool
     */
    public function overrideStatuses()
    {
        return $this->overrideStatuses;
    }

    /**
     * @return StatusCollection
     */
    public function statuses()
    {
        return $this->statuses;
    }

    public function spaceId()
    {
        return $this->spaceId;
    }

    public function setSpaceId($spaceId)
    {
        $this->spaceId = $spaceId;
    }

    /**
     * @param Space $space
     */
    public function setSpace(Space $space)
    {
        $this->space = $space;
    }

    /**
     * @param StatusCollection $statuses
     */
    public function setStatuses(StatusCollection $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/list/create-list.html
     * @param array $body
     * @return TaskList|null
     */
    public function createTaskList($body)
    {
        return new TaskList(
            $this->client(),
            $this->client()->post(
                "folder/{$this->id()}/list",
                $body
            )
        );
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function teamId()
    {
        return $this->space()->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Space
     */
    public function space()
    {
        return $this->space;
    }

    /**
     * @return array
     */
    protected function taskFindParams()
    {
        return ['folder_ids' => [$this->id()]];
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->orderIndex = isset($array['orderindex']) ? $array['orderindex'] : false;
        $this->isHidden = isset($array['hidden']) ? $array['hidden'] : false;
        $this->taskCount = isset($array['task_count']) ? $array['task_count'] : false;
        $this->taskLists = new TaskListCollection($this, $array['lists']);
        $this->overrideStatuses = isset($array['override_statuses']) ? $array['override_statuses'] : false;

        if(isset($array['override_statuses']) and $array['override_statuses']) {
            $this->statuses = new StatusCollection($this->client(), $array['statuses']);
        }
    }
}
