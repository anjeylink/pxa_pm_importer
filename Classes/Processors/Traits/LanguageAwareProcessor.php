<?php


namespace Pixelant\PxaPmImporter\Processors\Traits;


use Pixelant\PxaPmImporter\Processors\LanguageAwareProcessorInterface;

trait LanguageAwareProcessor
{
    /**
     * @var int
     */
    protected $languageId = 0;

    /**
     * @inheritDoc
     */
    public function getLanguageId(): int
    {
        // TODO: Implement getLanguageId() method.
    }

    /**
     * @inheritDoc
     */
    public function setLanguageId(int $languageId)
    {
        // TODO: Implement setLanguageId() method.
    }
}
