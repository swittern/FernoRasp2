<?
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
		
		protected function GetRemoteCode(string $CodeID) {

			//Codes definieren
			$FCodeArray = array(
			"1ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633331243316333312412254141433312541414331416143314141261433141241",
			"1as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633314314316333143122252431433312524314331416333141241263331412241",
			"1au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333124316333331222263141433331631414331225433333331254333333141",
			"11d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141224316331412222254141433312541414331416141414331261414143141",
			"11s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141433316331414312252431433312524314331416331412431263314124141",
			"11u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124143126331241414163141433331631414331225431243143154312431222",
			"12d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543122224315431222222254141433312541414331415241224331252412243141",
			"12s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141433125431414314152431433312524314331415431412433154314124122",
			"12u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543124143315431241412263141433331631414331226141243143161412431222",
			"13d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614122243126141222414154141433312541414331416312224141263122241241",
			"13s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614141414316141414122252431433312524314331416141412241261414122241",
			"13u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124124126141241224163141433331631414331225241243333152412433122",
			"14d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524122224125241222224154141433312541414331415412224331254122243141",
			"14s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141433315241414312252431433312524314331415241412431252414124141",
			"14u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524143314315241433122263141433331631414331226312431243163124312222",
			"15d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631241414316312414122254141433312541414331416122412243161224122222",
			"15s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631224124126312241224152431433312524314331416312243331263122433141",
			"15u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631224333126312243314163141433331631414331225412241431254122414141",
			"16d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541222433125412224314154141433312541414331415222222431252222224141",
			"16s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541241243125412412414152431433312524314331415412414141254124141241",
			"16u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541224314125412243124163141433331631414331226122241243161222412222",
			"17d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122612243124126122431224154141433312541414331416333143331263331433141",
			"17s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122612222224126122222224152431433312524314331416122224331261222243141",
			"17u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122612222433126122224314163141433331631414331225222222431252222224141",
			"2ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633331243316333312412254143143312541431431416143124143161431241222",
			"2as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633312414126333124124152433143312524331431416333333333163333333122",
			"2au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633331224126333312224163143143331631431431225433124331254331243141",
			"21d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124333316331243312254143143312541431431416141412433161414124122",
			"21s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633143143316331431412252433143312524331431416331243141263312431241",
			"21u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633143314316331433122263143143331631431431225431241241254312412241",
			"22d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141414315431414122254143143312541431431415241222241252412222241",
			"22s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543124124125431241224152433143312524331431415431414331254314143141",
			"22u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141433125431414314163143143331631431431226141222431261412224141",
			"23d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614143143126141431414154143143312541431431416312243143163122431222",
			"23s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614122224316141222222252433143312524331431416141431431261414314141",
			"23u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124143316141241412263143143331631431431225241414141252414141241",
			"24d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524122243315241222412254143143312541431431415412431241254124312241",
			"24s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141414125241414124152433143312524331431415241222241252412222241",
			"24u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524124333315241243312263143143331631431431226312412433163124124122",
			"3ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333143126333331414154141243331541412431226143314141261433141241",
			"3as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633314314316333143122252431243331524312431226333122243163331222222",
			"3au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333124316333331222263141243312631412431415433314333154333143122",
			"31d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141224316331412222254141243331541412431226141431431261414314141",
			"31s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141433316331414312252431243331524312431226331433143163314331222",
			"31u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141243126331412414163141243312631412431415431431243154314312222",
			"32d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543143314125431433124154141243331541412431225241412243152414122222",
			"32s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543122414125431224124152431243331524312431225431243331254312433141",
			"32u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543122224315431222222263141243312631412431416141241433161412414122",
			"33d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124333126141243314154141243331541412431226312222431263122224141",
			"33s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124314316141243122252431243331524312431226141222243161412222222",
			"33u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614143124316141431222263141243312631412431415241414333152414143122",
			"34d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141224315241412222254141243331541412431225412431433154124314122",
			"34s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141433315241414312252431243331524312431225241433143152414331222",
			"34u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141243125241412414163141243312631412431416312431243163124312222",
			"35d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631241414316312414122254141243331541412431226122433331261224333141",
			"35s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631224124126312241224152431243331524312431226312224333163122243122",
			"35u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122631241433126312414314163141243312631412431415412433143154124331222",
			"36d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541243143315412431412254141243331541412431225222414143152224141222",
			"36s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541224314125412243124152431243331524312431225412222241254122222241",
			"36u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122541224124315412241222263141243312631412431416122224331261222243141",
			"4ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633314333126333143314154143314312541433141416143333143161433331222",
			"4as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333143126333331414152433314312524333141416333124141263331241241",
			"4au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633312243126333122414163143314331631433141225433312243154333122222",
			"41d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124314126331243124154143314312541433141416141433333161414333122",
			"41s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633143124126331431224152433314312524333141416331224331263312243141",
			"41u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633122224126331222224163143314331631433141225431412433154314124122",
			"42d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543122433315431224312254143314312541433141415241414141252414141241",
			"42s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141243315431412412252433314312524333141415431241241254312412241",
			"42u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141414315431414122263143314331631433141226141243331261412433141",
			"43d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124124126141241224154143314312541433141416312431431263124314141",
			"43s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614141243316141412412252433314312524333141416141241241261412412241",
			"43u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124314316141243122263143314331631433141225241433331252414333141",
			"44d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524122414315241224122254143314312541433141415412414333154124143122",
			"44s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141224315241412222252433314312524333141415241241431252412414141",
			"44u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524122433125241224314163143314331631433141226312414143163124141222",
			"5ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633314143316333141412254141414331541414141226143141243161431412222",
			"5as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333314126333333124152431414331524314141226333333333163333333122",
			"5au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633312414126333124124163141414312631414141415433124331254331243141",
			"51d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124124316331241222254141414331541414141226141241433161412414122",
			"51s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124333316331243312252431414331524314141226331243141263312431241",
			"51u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124143126331241414163141414312631414141415431241241254312412241",
			"52d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543122243125431222414154141414331541414141225241222241252412222241",
			"52s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543141414315431414122252431414331524314141225431414331254314143141",
			"52u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543124124125431241224163141414312631414141416141241433161412414122",
			"53d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614122224316141222222254141414331541414141226312222431263122224141",
			"53s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614141433126141414314152431414331524314141226141414143161414141222",
			"53u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122614124143316141241412263141414312631414141415241241243152412412222",
			"54d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524122243315241222412254141414331541414141225412222241254122222241",
			"54s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524141414125241414124152431414331524314141225241414333152414143122",
			"54u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122524124124315241241222263141414312631414141416312241433163122414122",
			"6ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633312224316333122222254143124331541431241226143333143161433331222",
			"6as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633331433126333314314152433124331524331241226333124141263331241241",
			"6au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633331243316333312412263143124312631431241415433122241254331222241",
			"61d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633143314316331433122254143124331541431241226141243331261412433141",
			"61s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633122414316331224122252433124331524331241226331431433163314314122",
			"61u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633141224316331412222263143124312631431241415431222431254312224141",
			"7ad"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633314333126333143314154141224312541412241416143124143161431241222",
			"7as"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633333143126333331414152431224312524312241416333312241263333122241",
			"7au"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633312243126333122414163141224331631412241225433143333154331433122",
			"71d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633124314126331243124154141224312541412241416141224333161412243122",
			"71s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633143124126331431224152431224312524312241416331412431263314124141",
			"71u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122633122224126331222224163141224331631412241225431243143154312431222",
			"72d"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543124333125431243314154141224312541412241415241224143152412241222",
			"72s"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543143143125431431414152431224312524312241415431412241254314122241",
			"72u"=>"71111111633333314126333333124163333124331633331241225412431433154124314122543143314125431433124163141224331631412241226141414331261414143141",
			"aad"=>"81111111633333314126333333124163333124331633331241225412431433154124314122633333124316333331222254143143312541431431416143143333161431433122",
			"aas"=>"81111111633333314126333333124163333124331633331241225412431433154124314122633333143316333312412252431243331524312431226333331243163333312222",
			"aau"=>"81111111633333314126333333124163333124331633331241225412431433154124314122633331224126333312224163143143331631431431225433124331254331243141",
			);
		
			$remoteCode = $FCodeArray[$CodeID];

			return $remoteCode;
		}

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
			
			print_r($CodeID);
			
			// Steuercode aus Array holen
			$Code = GetRemoteCode[$CodeID];

			print_r($Code);
        }
		
        public function ShutterDown() {
			$ParentID = $this->GetParent();
		
			$CodeID = $this->BuildCode()."d";
			// Steuercode aus Array holen
			$Code = GetRemoteCode[$CodeID];

			print_r($Code);			
        }

        public function ShutterStop() {
			$ParentID = $this->GetParent();
			
			$CodeID = $this->BuildCode()."s";			
			
			// Steuercode aus Array holen
			$Code = GetRemoteCode[$CodeID];
			print_r($Code);
		}
		
    }
?>