<?php
declare(strict_types=1);

namespace Pixelant\PxaPmImporter\Validation;

use Pixelant\PxaPmImporter\Validation\Validator\ValidatorFactory;

/**
 * @package Pixelant\PxaPmImporter\Validation
 */
class ValidationManager
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * Keep last failed validation result
     *
     * @var ValidationResult
     */
    protected $validationResult = null;

    /**
     * @var ValidatorFactory
     */
    protected $factory;

    /**
     * @param array $configuration
     * @param ValidatorFactory $factory
     */
    public function __construct(array $configuration, ValidatorFactory $factory)
    {
        $this->configuration = $configuration;
        $this->factory = $factory;
    }

    /**
     * Validate import row
     *
     * @param array $row
     * @return bool
     */
    public function isValid(array $row): bool
    {
        // Reset
        $this->validationResult = null;

        foreach ($this->configuration as $property => $validators) {
            $value = $row[$property] ?? null;

            foreach ($validators as $validatorName) {
                $validator = $this->factory->create($validatorName);
                $validationResult = $validator->validate($value);

                if (!$validationResult->passed()) {
                    $this->addPropertyToError($validationResult, $property);
                    $this->validationResult = $validationResult;
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return ValidationResult
     */
    public function getLastValidationResult(): ValidationResult
    {
        return $this->validationResult;
    }

    /**
     * @param ValidationResult $validationResult
     * @param $property
     */
    protected function addPropertyToError(ValidationResult $validationResult, $property): void
    {
        $validationResult->setError(sprintf(
            'Validation of property "%s" failed with message "%s"',
            $property,
            $validationResult->getError()
        ));
    }
}
