<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Service\Configuration;

use Pixelant\PxaPmImporter\Exception\InvalidConfigurationSourceException;
use Pixelant\PxaPmImporter\Traits\EmitSignalTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractConfiguration
 * @package Pixelant\PxaPmImporter\Service
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    use EmitSignalTrait;

    /**
     * Configuration from source
     *
     * @var array
     */
    protected $configuration = null;

    /**
     * Initialize configuration
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Getter for configuration, return full array
     *
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * Source configuration
     *
     * @return array
     */
    public function getSourceConfiguration(): array
    {
        $configuration = $this->getConfiguration();

        if (!isset($configuration['source']) || !is_array($configuration['source'])) {
            throw new \UnexpectedValueException('Configuration expect "source" to be set as array.', 1538134061217);
        }
        return $configuration['source'];
    }

    /**
     * Importer configuration
     *
     * @return array
     */
    public function getImportersConfiguration(): array
    {
        $configuration = $this->getConfiguration();

        if (!isset($configuration['importers']) || !is_array($configuration['importers'])) {
            throw new \UnexpectedValueException('Configuration expect "importers" to be set as array.', 1538134039200);
        }
        return $configuration['importers'];
    }

    /**
     * Read custom log path from settings
     *
     * @return string|null
     */
    public function getLogCustomPath(): ?string
    {
        $configuration = $this->getConfiguration();
        if (!empty($configuration['log']['path'])) {
            return $configuration['log']['path'];
        }

        return null;
    }

    /**
     * Initialize main method
     */
    protected function initialize(): void
    {
        if ($this->isSourceValid()) {
            $configuration = $this->parseConfiguration();
            $this->emitSignal('postConfigurationParse', [&$configuration]);

            $this->configuration = $configuration;
        } else {
            // @codingStandardsIgnoreStart
            throw new InvalidConfigurationSourceException('Configuration source "' . $this->getConfigurationSource() . '" is invalid', 1535959642938);
            // @codingStandardsIgnoreEnd
        }
    }

    /**
     * Check if file path is valid
     *
     * @param string $filePath
     * @return bool
     */
    protected function isFileValid(string $filePath): bool
    {
        return file_exists($filePath) && is_readable($filePath);
    }

    /**
     * Parse configuration source as array
     * @return array
     */
    abstract protected function parseConfiguration(): array;

    /**
     * Return configuration source
     *
     * @return string
     */
    abstract protected function getConfigurationSource(): string;
}
