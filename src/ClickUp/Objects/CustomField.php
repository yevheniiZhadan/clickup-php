<?php

namespace ClickUp\Objects;

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
    public function type()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isHideFromGuests()
    {
        return $this->isHideFromGuests;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param $array
     */
    protected function fromArray($array)
    {
        $this->id = isset($array['id']) ? $array['id'] : false;
        $this->name = isset($array['name']) ? $array['name'] : false;
        $this->type = isset($array['type']) ? $array['type'] : false;
        $this->isHideFromGuests = isset($array['hide_from_guests']) ? $array['hide_from_guests'] : false;
        $this->value = isset($array['value']) ? $array['value'] : false;
        $this->isRequired = isset($array['required']) ? $array['required'] : false;
    }
}
