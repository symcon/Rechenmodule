<?php

declare(strict_types=1);

class UmrechnenMultiGrenzen extends IPSModule
{
    const LEGACYBORDERCOUNT = 10;

    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyInteger('SourceVariable', 0);

        $this->RegisterPropertyFloat('Border0', 0);
        $this->RegisterVariableFloat('Value', 'Value', '', 0);
        for ($i = 1; $i <= self::BORDERCOUNT; $i++) {
            $this->RegisterPropertyString('Formula' . $i, '');
            $this->RegisterPropertyFloat('Border' . $i, 0.0000);
        }
        $this->RegisterPropertyString('CalculationData', '');
    }

    public function ApplyChanges()
    {

        //Never delete this line!
        parent::ApplyChanges();

        $eid = @IPS_GetObjectIDByIdent('SourceTrigger', $this->InstanceID);
        if ($eid) {
            IPS_DeleteEvent($this->GetIDForIdent('SourceTrigger'));
        }

        //Check whether to transfer legacy data
        $transferLegacy = false;
        for ($i = 1; $i <= self::LEGACYBORDERCOUNT; $i++) {
            if ($this->ReadPropertyString('Formula' . $i) != '') {
                $transferLegacy = true;
                break;
            }
        }

        //Transfer legacy data
        if ($transferLegacy == true) {
            $calculationData = json_decode($this->ReadPropertyString('CalculationData'), true);
            for ($i = 1; $i <= self::LEGACYBORDERCOUNT; $i++) {
                if ($this->ReadPropertyFloat('Border' . ($i - 1)) == 0 && $this->ReadPropertyString('Formula' . $i) == '') {
                    continue;
                }
                $calculationData[] = [
                    'Border'  => $this->ReadPropertyFloat('Border' . ($i - 1)),
                    'Formula' => $this->ReadPropertyString('Formula' . $i)
                ];
                IPS_SetProperty($this->InstanceID, 'Border' . ($i - 1), 0);
                IPS_SetProperty($this->InstanceID, 'Formula' . $i, '');
            }
            IPS_SetProperty($this->InstanceID, 'CalculationData', json_encode($calculationData));
            IPS_ApplyChanges($this->InstanceID);
            return;
        }

        $sourceVariable = $this->ReadPropertyInteger('SourceVariable');
        if (IPS_VariableExists($sourceVariable)) {
            //Create our trigger
            $this->RegisterMessage($sourceVariable, VM_UPDATE);
            SetValue($this->GetIDForIdent('Value'), $this->Calculate(GetValue($sourceVariable)));
        }

        //Add references
        foreach ($this->GetReferenceList() as $reference) {
            $this->UnregisterReference($reference);
        }
        $sourceID = $this->ReadPropertyInteger('SourceVariable');
        if ($sourceID != 0) {
            $this->RegisterReference($sourceID);
        }
    }

    public function GetConfigurationForm()
    {
        $elements = [];
        $elements[] = [
            'type'    => 'List',
            'name'    => 'CalculationData',
            'caption' => 'Calculations',
            'add'     => true,
            'delete'  => true,
            'sort'    => [
                'column'    => 'Border',
                'diraction' => 'ascending'
            ],
            'columns' => [
                [
                    'caption' => 'Border',
                    'name'    => 'Border',
                    'width'   => '500px',
                    'add'     => 0,
                    'edit'    => [
                        'type'   => 'NumberSpinner',
                        'digits' => 4
                    ]
                ],
                [
                    'caption'  => 'Formula',
                    'name'     => 'Formula',
                    'width'    => 'auto',
                    'add'      => '',
                    'edit'     => [
                        'type' => 'ValidationTextBox'
                    ]
                ]

            ]

        ];
        $actions = [];
        $actions[] = ['name' => 'Value', 'type' => 'ValidationTextBox', 'caption' => 'Value'];
        $actions[] = ['type' => 'Button', 'label' => 'Calculate', 'onClick' => 'echo UMG_Calculate($id, $Value);'];

        return json_encode(['elements' => $elements]);
    }

    public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    {
        SetValue($this->GetIDForIdent('Value'), $this->Calculate($Data[0]));
    }

    public function Calculate(float $Value)
    {
        $calculationData = json_decode($this->ReadPropertyString('CalculationData'), true);
        usort($calculationData, function ($a, $b)
        {
            return $a['Border'] <=> $b['Border'];
        });
        for ($i = 0; $i < count($calculationData); $i++) {
            if (($Value >= $calculationData[$i]['Border']) &&
                (!isset($calculationData[$i + 1]['Border']) || ($Value < $calculationData[$i + 1]['Border'])) &&
                ($calculationData[$i]['Formula'] != '')) {
                eval('$Value = ' . $calculationData[$i]['Formula'] . ';');
                $this->SendDebug('Calculation success', 'Value: ' . $Value . '| GrenzeUnten: ' . $calculationData[$i - 1]['Border'] . '| GrenzeOben: ' . $calculationData[$i]['Border'] . ' Iteration ' . $i . '| Formel: ' . $calculationData[$i]['Formula'], 0);
                break;
            }
        }
        return $Value;
    }
}