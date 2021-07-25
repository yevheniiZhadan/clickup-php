<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class TaskList
 *
 * @package ClickUp\Objects
 */
class TaskList extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var string $content */
    private $content;

    /* @var Folder $folder */
    private $folder;

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param  Folder  $folder
     */
    public function setFolder(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/list/edit-list.html
     *
     * @param  array  $body
     *
     * @return array
     * @throws GuzzleException
     */
    public function edit(array $body): array
    {
        return $this->client()->put(
            "list/{$this->id()}",
            $body
        );
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/task/create-task-in-list?console=1.html
     *
     * @param  array  $body
     *
     * @return Task | null
     * @throws GuzzleException
     */
    public function createTask(array $body): ?Task
    {
        return new Task(
            $this->client(),
            $this->client()->post(
                "list/{$this->id()}/task",
                $body
            )
        );
    }

    /**
     * @return int
     */
    public function teamId(): int
    {
        return $this->folder()->space()->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Folder
     */
    public function folder(): Folder
    {
        return $this->folder;
    }

    /**
     * @return array
     */
    protected function taskFindParams(): array
    {
        return ['list_ids' => [$this->id()]];
    }

    /**
     * @param  array  $array
     */
    protected function fromArray($array)
    {
        // @todo Add another params
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->content = $array['content'] ?? false;
    }
}
