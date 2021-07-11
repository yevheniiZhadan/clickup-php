<?php

namespace ClickUp\Objects;

/**
 * @method Folder   getByKey(int $projectId)
 * @method Folder   getByName(string $projectName)
 * @method Folder[] objects()
 * @method Folder[] getIterator()
 */
class FolderCollection extends AbstractObjectCollection
{
    public function __construct(Space $space, $array)
    {
        parent::__construct($space->client(), $array);
        foreach ($this as $project) {
            $project->setSpace($space);
            if($project->overrideStatuses() === false) {
                $project->setStatuses($space->statuses());
            }
        }
    }

    /**
     * @return string
     */
    protected function objectClass()
    {
        return Folder::class;
    }
}
