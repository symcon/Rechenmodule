<?php

declare(strict_types=1);

class UmrechnenMultiGrenzen extends IPSModule
{
    const BORDERCOUNT = 10;

    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyInteger('SourceVariable', 0);

        $this->RegisterPropertyFloat('Border0', 0);
        $this->RegisterPropertyString('CalculationData', '');
        $this->RegisterVariableFloat('Value', 'Value', '', 0);
        for ($i = 1; $i <= self::BORDERCOUNT; $i++) {
            $this->RegisterPropertyString('Formula' . $i, '');
            $this->RegisterPropertyFloat('Border' . $i, 0.0000);
        }
    }

    public function ApplyChanges()
    {

        //Never delete this line!
        parent::ApplyChanges();

        $eid = @IPS_GetObjectIDByIdent('SourceTrigger', $this->InstanceID);
        if ($eid) {
            IPS_DeleteEvent($this->GetIDForIdent('SourceTrigger'));
        }

        //Transfer legacy Data
        //$form = json_decode($this->GetConfigurationForm())
        $this->SendDebug('Legacy', $this->GetConfigurationForm(), 0);

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
            if ($Value >= $calculationData[$i]['Border'] && $Value < $calculationData[$i + 1]['Border'] && $calculationData[$i]['Formula']) {
                eval('$Value = ' . $calculationData[$i]['Formula'] . ';');
                $this->SendDebug('Calc success', 'Value: ' . $Value . '| GrenzeUnten: ' . $calculationData[$i - 1]['Border'] . '| GrenzeOben: ' . $calculationData[$i]['Border'] . ' Iteration ' . $i . '| Formel: ' . $calculationData[$i]['Formula'], 0);
                break;
            }
        }
        return $Value;
    }
}