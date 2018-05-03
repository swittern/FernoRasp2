<?
	include __DIR__ . "/../libs/FR_Codes.php";

	// Klassendefinition
    class FernoShutter extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
 
			// Registrieren der Parameter
			// Verbinden mit RaspberryGateway
			$this->ConnectParent("{7937E42B-1E93-454B-B2B4-5F754073B217}");
			
			$this->RegisterPropertyInteger("GroupID", 0);				// Gruppennummer des Rolladen (1-7)
			$this->RegisterPropertyInteger("DeviceID", 0);				// Gerätenummer des Rolladen (1-7)
			$this->RegisterPropertyBoolean("MasterControl", false);		// Ist die Instanz Mastercontoller (alle Shutter)
			$this->RegisterPropertyBoolean("GroupControl", false);		// Ist die Instanz Gruppencontroller (alle Shutter der Gruppe)
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			
			$GroupID = $this->ReadPropertyInteger("GroupID");
			$DeviceID = $this->ReadPropertyInteger("DeviceID");
			$GroupControl = $this->ReadPropertyBoolean("GroupControl");			
			$MasterControl = $this->ReadPropertyBoolean("MasterControl");
			
			$this->ValidateConfiguration();	
        }
		
		public function Destroy() {
			//Never delete this line!
			parent::Destroy();
			
		}
		
		private function ValidateConfiguration(){
		}
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        */
		protected function GetParent() {
    	    $instance = IPS_GetInstance($this->InstanceID);//array
			return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
	    }

		protected function BuildCode() {
			$GroupID = $this->ReadPropertyInteger("GroupID");
			$DeviceID = $this->ReadPropertyInteger("DeviceID");
			$GroupControl = $this->ReadPropertyBoolean("GroupControl");			
			$MasterControl = $this->ReadPropertyBoolean("MasterControl");

			if($GroupControl) {
				$CodeID = $GroupID."a";
			} elseif($MasterControl) {
				$CodeID = "aa";
			} else {
				$CodeID = $DeviceID.$GroupID;							
			}
			
			print_r($CodeID);

			
			return $CodeID;
		}


        public function ShutterUp() {
			// CHECK OUT: https://github.com/Wolbolar/IPSymconAIOGateway/blob/master/AIO%20Somfy%20RTS%20Device/module.php
			$ParentID = $this->GetParent();

			$CodeID = $this->BuildCode()."u";			
			// Steuercode aus Array holen
			$Code = $FCodeArray[$CodeID];

			print_r($Code);
        }
		
        public function ShutterDown() {
			$ParentID = $this->GetParent();
		
			$CodeID = $this->BuildCode()."d";
			// Steuercode aus Array holen
			$Code = $FCodeArray[$CodeID];

			print_r($Code);			
        }

        public function ShutterStop() {
			$ParentID = $this->GetParent();
			
			$CodeID = $this->BuildCode()."s";			
			
			// Steuercode aus Array holen
			$Code = $FCodeArray[$CodeID];
			print_r($Code);
		}
		
    }
?>