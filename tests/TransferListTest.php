<?php

declare(strict_types=1);

include_once __DIR__ . '/stubs/GlobalStubs.php';
include_once __DIR__ . '/stubs/KernelStubs.php';
include_once __DIR__ . '/stubs/ModuleStubs.php';

use PHPUnit\Framework\TestCase;

class TransferListTest extends TestCase
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

    public function testPropertyTransfer()
    {

        //Instance
        $instanceID = IPS_CreateInstance('{D40D120A-C525-4DFC-9F44-ED6E43890C63}');

        //Configuration
        IPS_SetConfiguration($instanceID, json_encode(
            [
                'Border0'  => 0,
                'Formula1' => '$Value * 2',
                'Border1'  => 5,
                'Formula2' => '$Value * 5',
                'Border4'  => 0,
                'Formula5' => ''
            ]
        ));
        IPS_ApplyChanges($instanceID);

        //Check Properties
        $this->assertEquals('[{"Border":0,"Formula":"$Value * 2"},{"Border":5,"Formula":"$Value * 5"}]', IPS_GetProperty($instanceID, 'CalculationData'));
        $this->assertEquals('', IPS_GetProperty($instanceID, 'Formula1'));
        $this->assertEquals(0, IPS_GetProperty($instanceID, 'Border1'));
    }

    public function testEmptyPropertyTransfer()
    {

        //Instance
        $instanceID = IPS_CreateInstance('{D40D120A-C525-4DFC-9F44-ED6E43890C63}');
        //Setting custom time for testing

        //Configuration
        IPS_SetConfiguration($instanceID, json_encode([]));
        IPS_ApplyChanges($instanceID);

        //Check Properties
        $this->assertEquals('[]', IPS_GetProperty($instanceID, 'CalculationData'));
        $this->assertEquals('', IPS_GetProperty($instanceID, 'Formula1'));
        $this->assertEquals(0, IPS_GetProperty($instanceID, 'Border1'));
        $this->assertTrue(true);
    }
}