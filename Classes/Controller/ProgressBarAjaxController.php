<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handle backend ajax requests
 *
 * @package Pixelant\PxaPmImporter\Controller
 */
class ProgressBarAjaxController
{
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


        $response->getBody()->write(json_encode(['progress' => $importId]));

        return $response;
    }
}