<?php

namespace ClickUp\Objects;

class Tag extends AbstractObject
{
    /** @var string $name */
    private $name;

    /** @var string $tag_fg */
    private $tag_fg;

    /** @var string $tag_bg */
    private $tag_bg;

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
    public function tagFg()
    {
        return $this->tag_fg;
    }

    /**
     * @return string
     */
    public function tagBg()
    {
        return $this->tag_bg;
    }

    protected function fromArray($array)
    {
        $this->name = isset($array['name']) ? $array['name'] : false;
        $this->tag_fg = isset($array['tag_fg']) ? $array['tag_fg'] : false;
        $this->tag_bg = isset($array['tag_bg']) ? $array['tag_bg'] : false;
    }
}
