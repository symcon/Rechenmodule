<?php

declare(strict_types=1);

    class Umrechnen extends IPSModule
    {
        public function Create()
        {
            //Never delete this line!
            parent::Create();

            $this->RegisterPropertyInteger('SourceVariable', 0);
            $this->RegisterPropertyString('Formula', '$Value/10*sin(30)*pi()');

            $this->RegisterVariableFloat('Value', 'Value', '', 0);
        }

        public function ApplyChanges()
        {

            //Never delete this line!
            parent::ApplyChanges();

            $eid = @$this->GetIDForIdent('SourceTrigger');
            if ($eid) {
                IPS_DeleteEvent($eid);
            }

            $sourceVariable = $this->ReadPropertyInteger('SourceVariable');
            if (IPS_VariableExists($sourceVariable)) {
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
            eval('$Value = ' . $this->ReadPropertyString('Formula') . ';');

            return $Value;
        }
    }