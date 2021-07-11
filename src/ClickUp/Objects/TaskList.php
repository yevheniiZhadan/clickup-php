<?php

namespace ClickUp\Objects;

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
    public function name()
    {
        return $this->name;
    }

    /**
     * @param Folder $folder
     */
    public function setFolder(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/list/edit-list.html
     * @param array $body
     * @return array
     */
    public function edit($body)
    {
        return $this->client()->put(
            "list/{$this->id()}",
            $body
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
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/task/create-task-in-list?console=1.html
     * @param array $body
     * @return array
     */
    public function createTask($body)
    {
        return $this->client()->post(
            "list/{$this->id()}/task",
            $body
        );
    }

    /**
     * @return int
     */
    public function teamId()
    {
        return $this->folder()->space()->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Folder
     */
    public function folder()
    {
        return $this->folder;
    }

    /**
     * @return array
     */
    protected function taskFindParams()
    {
        return ['list_ids' => [$this->id()]];
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        // @todo Add another params
        $this->id = isset($array['id']) ? $array['id'] : false;
        $this->name = isset($array['name']) ? $array['name'] : false;
        $this->content = isset($array['content']) ? $array['content'] : false;
    }
}
