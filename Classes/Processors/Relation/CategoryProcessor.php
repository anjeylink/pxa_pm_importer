<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Processors\Relation;

use Pixelant\PxaProductManager\Domain\Model\Category;

/**
 * Class CategoryProcessor
 * @package Pixelant\PxaPmImporter\Processors
 */
class CategoryProcessor extends AbstractRelationFieldProcessor implements CanCreateMissingEntities
{
    /**
     * @inheritDoc
     */
    public function createMissingEntity(string $importId)
    {
        $fields = ['title' => $importId, $this->tcaHiddenField() => 1];

        $this->repository->createEmpty(
            $importId,
            'sys_category',
            $this->getLanguageId(),
            $this->newRecordFieldsWithPlaceHolder($fields)
        );
    }

    /**
     * @inheritDoc
     */
    protected function domainModel(): string
    {
        return Category::class;
    }
}
