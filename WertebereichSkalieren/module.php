<?php

declare(strict_types=1);
class WertebereichSkalieren extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterVariableFloat('Output', $this->Translate('Output'), '', 0);

        $this->RegisterPropertyInteger('InputID', 0);
        $this->RegisterPropertyFloat('MinInput', 0.);
        $this->RegisterPropertyFloat('MaxInput', 0.);
        $this->RegisterPropertyFloat('MinOutput', 0.);
        $this->RegisterPropertyFloat('MaxOutput', 0.);
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Unregister all messages in order to readd them
        foreach ($this->GetMessageList() as $senderID => $messages) {
            foreach ($messages as $message) {
                $this->UnregisterMessage($senderID, $message);
            }
        }

        //Never delete this line!
        parent::ApplyChanges();

        $this->RegisterMessage($this->ReadPropertyInteger('InputID'), VM_UPDATE);
    }

    public function MessageSink($TimeStamp, $SendID, $MessageID, $Data): void
    {
        if ($MessageID == VM_UPDATE) {
            $this->Scale();
        }
    }

    public function Scale(): bool
    {
        $inputID = $this->ReadPropertyInteger('InputID');
        if (!IPS_VariableExists($inputID)) {
            return false;
        }

        $input = GetValue($inputID);
        $minInput = $this->ReadPropertyFloat('MinInput');
        $maxInput = $this->ReadPropertyFloat('MaxInput');
        $minOutput = $this->ReadPropertyFloat('MinOutput');
        $maxOutput = $this->ReadPropertyFloat('MaxOutput');

        $output = ((($input - $minInput) / ($maxInput - $minInput)) * ($maxOutput - $minOutput)) + $minOutput;
        $this->SetValue('Output', $output);
        return true;
    }
}