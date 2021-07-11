<?php


namespace ClickUp\Objects;


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
     * Access parent class.
     *
     * @return Team
     */
    public function team()
    {
        return $this->team;
    }

    /**
     * @param Team $team
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
        $this->id = isset($array['id']) ? $array['id'] : false;
        $this->name = isset($array['name']) ? $array['name'] : false;
        $this->isCustom = isset($array['custom']) ? $array['custom'] : false;
    }
}
