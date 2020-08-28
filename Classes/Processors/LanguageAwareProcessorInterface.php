<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Processors;

/**
 * @package Pixelant\PxaPmImporter\Processors
 */
interface LanguageAwareProcessorInterface
{
    /**
     * @return int TYPO3 sys_language UID
     */
    public function getLanguageId(): int;

    /**
     * @param int $languageId TYPO3 sys_language UID
     * @return void
     */
    public function setLanguageId(int $languageId);
}
