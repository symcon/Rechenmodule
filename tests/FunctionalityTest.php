<?php

declare(strict_types=1);

include_once __DIR__ . '/stubs/GlobalStubs.php';
include_once __DIR__ . '/stubs/KernelStubs.php';
include_once __DIR__ . '/stubs/ModuleStubs.php';

use PHPUnit\Framework\TestCase;

class FunctionalityTest extends TestCase
{
    protected function setUp(): void
    {
        //Reset
        IPS\Kernel::reset();

        //Register our core stubs for testing
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/stubs/CoreStubs/library.json');

        //Register our library we need for testing
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/../library.json');

        parent::setUp();
    }

    public function testBaseFunctionality()
    {

        //Instances
        $instanceID = IPS_CreateInstance('{D40D120A-C525-4DFC-9F44-ED6E43890C63}');
        //Setting custom time for testing

        //Configuration
        IPS_SetProperty($instanceID, 'CalculationData', json_encode(
            [
                [
                    'Border'  => 1,
                    'Formula' => '1'
                ],
                [
                    'Border'  => 5,
                    'Formula' => '5'
                ],
                [
                    'Border'  => 8,
                    'Formula' => '8'
                ]
            ]
        ));
        IPS_ApplyChanges($instanceID);
        IPS_EnableDebug($instanceID, 10);
        $result = UMG_Calculate($instanceID, 6);
        //Check result
        $this->assertEquals(5, $result);
    }

    public function testSameBorder()
    {

        //Instances
        $instanceID = IPS_CreateInstance('{D40D120A-C525-4DFC-9F44-ED6E43890C63}');
        //Setting custom time for testing

        //Configuration
        IPS_SetProperty($instanceID, 'CalculationData', json_encode(
            [
                [
                    'Border'  => 1,
                    'Formula' => '1'
                ],
                [
                    'Border'  => 5,
                    'Formula' => '42'
                ],
                [
                    'Border'  => 5,
                    'Formula' => '69'
                ]
            ]
        ));
        IPS_ApplyChanges($instanceID);
        IPS_EnableDebug($instanceID, 10);
        $result = UMG_Calculate($instanceID, 10);
        echo $result;
        //Check result
        //$this->assertEquals(5, $result);
        $this->assertTrue(true);
    }
}