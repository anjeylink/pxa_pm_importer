<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Controller;

use Pixelant\PxaPmImporter\Domain\Model\DTO\ImportStatusInfo;
use Pixelant\PxaPmImporter\Domain\Model\Import;
use Pixelant\PxaPmImporter\Domain\Repository\ImportRepository;
use Pixelant\PxaPmImporter\Service\Status\ImportProgressStatus;
use Pixelant\PxaPmImporter\Service\Status\ImportProgressStatusInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Handle backend ajax requests
 *
 * @package Pixelant\PxaPmImporter\Controller
 */
class ProgressBarAjaxController
{
    /**
     * @var ImportProgressStatusInterface
     */
    protected $importProgressStatus = null;

    /**
     * @var ImportRepository
     */
    protected $importRepository = null;

    /**
     * Initialize
     */
    public function __construct()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->importRepository = $objectManager->get(ImportRepository::class);
        $this->importProgressStatus = $objectManager->get(ImportProgressStatus::class);
    }

    /**
     * Check import loading progress status
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function importProgressStatusAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $importId = intval($request->getParsedBody()['importId'] ?? 0);
        /** @var Import $import */
        $import = $this->importRepository->findByUid($importId);

        $answer = ['status' => false];
        if ($import !== null) {
            $importStatus = $this->mportProgressStatus->getImportStatus($import);

            $answer = $this->getImportStatusArray($importStatus);
        }

        $response->getBody()->write(json_encode($answer));

        return $response;
    }

    /**
     * Get all running imports
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getAllRunningJobs(ServerRequestInterface $request, ResponseInterface $response)
    {
        $runningImports = [];
        foreach ($this->importProgressStatus->getAllRunningImports() as $importStatus) {
            $runningImports[] = $this->getImportStatusArray($importStatus);
        }

        $response->getBody()->write(json_encode($runningImports));

        return $response;
    }

    /**
     * Get import status as array
     * @param ImportStatusInfo $importStatusInfo
     * @return array
     */
    protected function getImportStatusArray(ImportStatusInfo $importStatusInfo): array
    {
        $status['status'] = $importStatusInfo->isAvailable();
        $status['name'] = $importStatusInfo->getImport()->getName();
        $status += $importStatusInfo->toArray();

        return $status;
    }
}
