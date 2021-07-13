<?php

namespace ClickUp\Objects;

use ClickUp\Traits\DateImmutableTrait;
use ClickUp\Traits\TaskFinderTrait;
use DateTimeImmutable;
use Exception;

/**
 * Class Task
 * @package ClickUp\Objects
 */
class Task extends AbstractObject
{
    use TaskFinderTrait, DateImmutableTrait;

    /* @var string $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var string $description */
    private $description;

    /* @var Status $status */
    private $status;

    /* @var string $orderindex */
    private $orderindex;

    /* @var DateTimeImmutable $dateCreated */
    private $dateCreated;

    /* @var DateTimeImmutable $dateUpdated */
    private $dateUpdated;

    /* @var TeamMember $creator */
    private $creator;

    /* @var TeamMemberCollection $assignees */
    private $assignees;

    /* @var TagCollection $tags */
    private $tags;

    /* @var string|null $parentTaskId */
    private $parentTaskId;

    /* @var Task|null $parentTask */
    private $parentTask = null;

    /* @var int $priority */
    private $priority;

    /* @var DateTimeImmutable $dueDate */
    private $dueDate;

    /* @var DateTimeImmutable $startDate */
    private $startDate;

    /* @var int $points */
    private $points;

    /* @var string $timeEstimate */
    private $timeEstimate;

    /** @var CustomFieldCollection */
    private $customFields;

    /* @var int $taskListId */
    private $taskListId;

    /* @var TaskList|null $taskList */
    private $taskList = null;

    /* @var int $folderId */
    private $folderId;

    /* @var Folder|null $folder */
    private $folder = null;

    /* @var int $spaceId */
    private $spaceId;

    /* @var Space|null $space */
    private $space = null;

    /* @var int $teamId */
    private $teamId;

    /* @var Team|null $team */
    private $team = null;

    /* @var TaskCommentCollection|null $comment */
    private $comment = null;

    /* @var string $url */
    private $url;

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return Status
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function orderindex()
    {
        return $this->orderindex;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @return TeamMember
     */
    public function creator()
    {
        return $this->creator;
    }

    /**
     * @return TeamMemberCollection
     */
    public function assignees()
    {
        return $this->assignees;
    }

    /**
     * @return TagCollection
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isSubTask()
    {
        return !is_null($this->parentTaskId());
    }

    /**
     * @return string|null
     */
    public function parentTaskId()
    {
        return $this->parentTaskId;
    }

    /**
     * @return Task|null
     */
    public function parentTask()
    {
        if(is_null($this->parentTaskId())) {
            return null;
        }
        if(is_null($this->parentTask)) {
            $this->parentTask = $this
                ->tasks()
                ->getByTaskId($this->parentTaskId());
        }
        return $this->parentTask;
    }

    /**
     * @return int
     */
    public function priority()
    {
        return $this->priority;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function startDate()
    {
        return $this->startDate;
    }

    /**
     * @return int
     */
    public function points()
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function timeEstimate()
    {
        return $this->timeEstimate;
    }

    /**
     * @return CustomFieldCollection
     */
    public function customField()
    {
        return $this->customFields;
    }

    /**
     * @return TaskList
     */
    public function taskList()
    {
        if(is_null($this->taskList)) {
            $this->taskList = $this->folder()->taskList($this->taskListId());
        }
        return $this->taskList;
    }

    /**
     * @return Folder
     */
    public function folder()
    {
        if(is_null($this->folder)) {
            $this->folder = $this->space()->folder($this->folderId());
        }
        return $this->folder;
    }

    /**
     * @return Space
     */
    public function space()
    {
        if(is_null($this->space)) {
            $this->space = $this->team()->space($this->spaceId());
        }
        return $this->space;
    }

    /**
     * @return Team
     */
    public function team()
    {
        if(is_null($this->team)) {
            $this->team = $this->client()->team($this->teamId());
        }
        return $this->team;
    }

    /**
     * @return TaskCommentCollection|null
     */
    public function comment()
    {
        if(!is_null($this->comment)) {
            $this->comment = new TaskCommentCollection(
                $this,
                $this->client()->get("task/{$this->id()}/comment")['comments']
            );
        }

        return $this->comment;
    }

    /**
     * @return int
     */
    public function teamId()
    {
        return $this->teamId;
    }

    /**
     * @return int
     */
    public function spaceId()
    {
        return $this->spaceId;
    }

    /**
     * @return int
     */
    public function folderId()
    {
        return $this->folderId;
    }

    /**
     * @return int
     */
    public function taskListId()
    {
        return $this->taskListId;
    }

    /**
     * @param $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/task/edit-task.html
     * @param array $body
     * @return array
     */
    public function edit($body)
    {
        return $this->client()->put(
            "task/{$this->id()}",
            $body
        );
    }

    /**
     * @param $array
     * @throws Exception
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->description = (string)$array['text_content'];
        $this->status = new Status(
            $this->client(),
            $array['status']
        );
        $this->orderindex = $array['orderindex'];
        $this->dateCreated = $this->getDate($array, 'date_created');
        $this->dateUpdated = $this->getDate($array, 'date_updated');
        $this->creator = new User(
            $this->client(),
            $array['creator']
        );
        $this->assignees = new UserCollection(
            $this->client(),
            $array['assignees']
        );

        $this->parentTaskId = $array['parent'];
        $this->priority = $array['priority'];
        $this->dueDate = $this->getDate($array, 'due_date');
        $this->startDate = $this->getDate($array, 'start_date');
        $this->points = isset($array['point']) ? $array['point'] : null;
        $this->timeEstimate = isset($array['time_estimate']) ? $array['time_estimate'] : null;
        $this->taskListId = $array['list']['id'];
        $this->folderId = $array['folder']['id'];
        $this->spaceId = $array['space']['id'];
        $this->url = $array['url'];

        if(isset($array['tags'])) {
            $this->tags = new TagCollection($this->client(), $array['tags']);
        }

        if(isset($array['custom_fields'])) {
            $this->customFields = new CustomFieldCollection($this->client(), $array['custom_fields']);
        }
    }
}
