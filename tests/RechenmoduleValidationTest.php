<?php

declare(strict_types=1);
include_once __DIR__ . '/stubs/Validator.php';
class RechenmoduleValidationTest extends TestCaseSymconValidation
{
    public function testValidateRechenmodule(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }
    public function testValidateComputationModuleModule(): void
    {
        $this->validateModule(__DIR__ . '/../Computation Module');
    }
    public function testValidateConverterModule(): void
    {
        $this->validateModule(__DIR__ . '/../Converter');
    }
    public function testValidateConvertMultiBoundariesModule(): void
    {
        $this->validateModule(__DIR__ . '/../ConvertMultiBoundaries');
    }
    public function testValidateWertebereichSkalierenModule(): void
    {
        $this->validateModule(__DIR__ . '/../ValueRangeScale');
    }
}
