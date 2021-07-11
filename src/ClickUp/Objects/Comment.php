<?php

namespace ClickUp\Objects;

use ClickUp\Traits\DateImmutableTrait;
use DateTimeImmutable;

/**
 * Class Comment
 * @package ClickUp\Objects
 */
class Comment extends AbstractObject
{
    use DateImmutableTrait;

    /** @var string */
    private $id;

    /** @var string */
    private $commentText;

    /** @var User */
    private $user;

    /** @var bool */
    private $isResolved;

    /** @var DateTimeImmutable */
    private $date;

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
    public function commentText()
    {
        return $this->commentText;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return DateTimeImmutable
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * @return bool
     */
    public function isResolved()
    {
        return $this->isResolved;
    }

    /**
     * @param $array
     * @throws \Exception
     */
    protected function fromArray($array)
    {
        $this->id = isset($array['id']) ? $array['id'] : false;
        $this->commentText = isset($array['comment_text']) ? $array['comment_text'] : false;
        $this->user = isset($array['user']) ? new User($this->client(), $array['user']) : false;
        $this->isResolved = isset($array['resolved']) ? $array['resolved'] : false;
        $this->date = isset($array['date']) ? $this->getDate($array, 'date') : false;
    }
}
