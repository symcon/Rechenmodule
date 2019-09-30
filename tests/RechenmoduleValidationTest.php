<?php

declare(strict_types=1);
include_once __DIR__ . '/stubs/Validator.php';
class RechenmoduleValidationTest extends TestCaseSymconValidation
{
    public function testValidateRechenmodule(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }
    public function testValidateRechenmodulModule(): void
    {
        $this->validateModule(__DIR__ . '/../Rechenmodul');
    }
    public function testValidateUmrechnenModule(): void
    {
        $this->validateModule(__DIR__ . '/../Umrechnen');
    }
    public function testValidateUmrechnenMultiGrenzenModule(): void
    {
        $this->validateModule(__DIR__ . '/../UmrechnenMultiGrenzen');
    }
}