<?php

namespace Pixelant\PxaPmImporter\Processors\Relation;

/**
 * @package Pixelant\PxaPmImporter\Processors\Relation
 */
interface CanCreateMissingEntities
{
    /**
     * Create missing entity with import ID
     *
     * @param string $importId
     * @return mixed
     */
    public function createMissingEntity(string $importId);
}
