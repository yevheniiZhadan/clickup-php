<?php

namespace ClickUp\Objects;

/**
 * Class CustomField
 *
 * @package ClickUp\Objects
 */
class CustomField extends AbstractObject
{
    /** @var string $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var string */
    private $type;

    /** @var bool $hideFromGuests */
    private $isHideFromGuests;

    /** @var string $value */
    private $value;

    /** @var bool $isRequired */
    private $isRequired;

    /**
     * @return string
     */
    public function id(): string
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
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isHideFromGuests(): bool
    {
        return $this->isHideFromGuests;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->type = $array['type'] ?? false;
        $this->isHideFromGuests = $array['hide_from_guests'] ?? false;
        $this->value = $array['value'] ?? false;
        $this->isRequired = $array['required'] ?? false;
    }
}
