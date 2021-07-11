<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;

/**
 * Class Space
 * @package ClickUp\Objects
 */
class Space extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var bool $isPrivate */
    private $isPrivate;

    /* @var StatusCollection $statuses */
    private $statuses;

    /* @var array $clickApps */
    private $clickApps;

    /* @var int|null $teamId */
    private $teamId;

    /* @var Team $team */
    private $team;

    /* @var FolderCollection|null $folders */
    private $folders = null;

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * @return StatusCollection
     */
    public function statuses()
    {
        return $this->statuses;
    }

    /**
     * @return array
     */
    public function clickApps()
    {
        return $this->clickApps;
    }

    /**
     * @param $folderId
     * @return Folder
     */
    public function folder($folderId)
    {
        return $this->folders()->getByKey($folderId);
    }

    /**
     * @return FolderCollection
     */
    public function folders()
    {
        if(is_null($this->folders)) {
            $this->folders = new FolderCollection(
                $this,
                $this->client()->get("space/{$this->id()}/folder")['folders']
            );
        }
        return $this->folders;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function teamId()
    {
        return $this->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Team
     */
    public function team()
    {
        return $this->team;
    }

    /**
     * @return array
     */
    protected function taskFindParams()
    {
        return ['space_ids' => [$this->id()]];
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->isPrivate = $array['private'];
        $this->statuses = new StatusCollection($this->client(), $array['statuses']);
        $this->clickApps = [
            'multiple_assignees' => isset($array['multiple_assignees']) ? $array['multiple_assignees'] : false,
            'due_dates' => isset($array['features']['due_dates']['enabled']) ? $array['features']['due_dates']['enabled'] : false,
            'time_tracking' => isset($array['features']['time_tracking']['enabled']) ? $array['features']['time_tracking']['enabled'] : false,
            'tags' => isset($array['features']['tags']['enabled']) ? $array['features']['tags']['enabled'] : false,
            'time_estimates' => isset($array['features']['time_estimates']['enabled']) ? $array['features']['time_estimates']['enabled'] : false,
            'checklists' => isset($array['features']['checklists']['enabled']) ? $array['features']['checklists']['enabled'] : false,
            'custom_fields' => isset($array['features']['custom_fields']['enabled']) ? $array['features']['custom_fields']['enabled'] : false,
            'remap_dependencies' => isset($array['features']['remap_dependencies']['enabled']) ? $array['features']['remap_dependencies']['enabled'] : false,
            'dependency_warning' => isset($array['features']['dependency_warning']['enabled']) ? $array['features']['dependency_warning']['enabled'] : false,
            'portfolios' => isset($array['features']['portfolios']['enabled']) ? $array['features']['portfolios']['enabled'] : false,
        ];
    }
}
