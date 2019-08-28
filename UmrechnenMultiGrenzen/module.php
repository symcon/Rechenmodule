<?

class UmrechnenMultiGrenzen extends IPSModule {

	const BORDERCOUNT = 10;

	public function Create() {
		//Never delete this line!
		parent::Create();
		
		$this->RegisterPropertyInteger("SourceVariable", 0);
		
		$this->RegisterPropertyFloat("Border0", 0);
		$this->RegisterVariableFloat("Value", "Value", "", 0);
		for ($i = 1; $i <= self::BORDERCOUNT; $i++) {
			$this->RegisterPropertyString("Formula".$i, "");
			$this->RegisterPropertyFloat("Border".$i, 0.0000);
		}
	}

	public function ApplyChanges() {
		
		//Never delete this line!
		parent::ApplyChanges();
		
		$eid = @IPS_GetObjectIDByIdent("SourceTrigger", $this->InstanceID);
		if($eid) {
			IPS_DeleteEvent($this->GetIDForIdent("SourceTrigger"));
		}

		if(IPS_VariableExists($this->ReadPropertyInteger("SourceVariable"))) {
			//Create our trigger
			$this->RegisterMessage($this->ReadPropertyInteger("SourceVariable"), VM_UPDATE);
		}
		
	}
	
	public function GetConfigurationForm() {
		
		$arrayElements = array();
		$arrayElements[] = array("name" => "SourceVariable", "type" => "SelectVariable", "caption" => "Source");
		$arrayElements[] = array("name" => "Border0", "type" => "NumberSpinner", "caption" => "Border 0", "digits" => 4);
		
		for ($i = 1; $i <= self::BORDERCOUNT; $i++) {
			$arrayElements[] = array("name" => "Formula".$i, "type" => "ValidationTextBox", "caption" => "Formula ".$i);
			$arrayElements[] = array("name" => "Border".$i, "type" => "NumberSpinner", "caption" => "Border ".$i, "digits" => 4);
		}
		
		$arrayActions = array();
		$arrayActions[] = array("name" => "Value", "type" => "ValidationTextBox", "caption" => "Value");
		$arrayActions[] = array("type" => "Button", "label" => "Calculate", "onClick" => "echo UMG_Calculate(\$id, \$Value);");
		
		return JSON_encode(array("elements" => $arrayElements, "actions" => $arrayActions));
	
	}

	public function MessageSink ($TimeStamp, $SenderID, $Message, $Data)
	{
		SetValue($this->GetIDForIdent("Value"), $this->Calculate($Data[0]));
	}

	public function Calculate(float $Value) {
		
		for ($i = 1; $i <= self::BORDERCOUNT; $i++) {
			if ($Value >= $this->ReadPropertyFloat("Border".($i - 1)) && $Value < $this->ReadPropertyFloat("Border".$i) && $this->ReadPropertyString("Formula".$i) != "") {
				eval("\$Value = " . $this->ReadPropertyString("Formula".$i) . ";");
				$this->SendDebug("Calc success", "Value: ".$Value." GrenzeUnten: ".$this->ReadPropertyFloat("Border".($i - 1))." GrenzeOben ".$this->ReadPropertyFloat("Border".$i)." Iteration ".$i." Formel: ".$this->ReadPropertyString("Formula".$i), 0);
				break;
			}
		}
		return $Value;
	
	}

}

?>
