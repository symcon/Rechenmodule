<?

	class Umrechnen extends IPSModule
	{
		
		public function Create()
		{
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyInteger("SourceVariable", 0);
			$this->RegisterPropertyString("Formula", "\$Value/10*sin(30)*pi()");
			
			$this->RegisterVariableFloat("Value", "Value", "", 0);
		}
	
		public function ApplyChanges()
		{
			
			//Never delete this line!
			parent::ApplyChanges();

			$eid = @$this->GetIDForIdent("SourceTrigger");
			if($eid) {
				IPS_DeleteEvent($eid);
			}

			if(IPS_VariableExists($this->ReadPropertyInteger("SourceVariable"))) {
				$this->RegisterMessage(($this->ReadPropertyInteger("SourceVariable")), VM_UPDATE);
			}
			
		}
	
		public function MessageSink ($TimeStamp, $SenderID, $Message, $Data)
		{
			SetValue($this->GetIDForIdent("Value"), $this->Calculate($Data[0]));
		}

		public function Calculate(float $Value)
		{
			
			eval("\$Value = " . $this->ReadPropertyString("Formula") . ";");
			
			return $Value;
		
		}
	
	}

?>
