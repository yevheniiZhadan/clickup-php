<?php

namespace ClickUp\Objects;

/**
 * Class TeamRole
 *
 * @package ClickUp\Objects
 */
class TeamRole extends AbstractObject
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var bool $custom */
    private $isCustom;

    /* @var Team $team */
    private $team;

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isCustom(): bool
    {
        return $this->isCustom;
    }

    /**
     * Access parent class.
     *
     * @return Team
     */
    public function team(): Team
    {
        return $this->team;
    }

    /**
     * @param  Team  $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @param $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->isCustom = $array['custom'] ?? false;
    }
}
