<?
    
	//require_once("lib/SSH2.php");  // diverse Klassen
	include __DIR__ . "/../libs/SSH2.php";
	//include __DIR__ . "/../libs/FR_Codes.php";
		
	
	// Klassendefinition
    class FernoRasp extends IPSModule {
 
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
 
					
			$this->RegisterPropertyString("GatewayIP", "");
			$this->RegisterPropertyString("Login", "");
			$this->RegisterPropertyString("Password", "");

			$this->RegisterVariableString("Command", "Command");
			 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			$GatewayIP = $this->ReadPropertyString("GatewayIP");
			$Login = $this->ReadPropertyString("Login");
			$Passwort = $this->ReadPropertyString("Password");
        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        */
        public function SendFernoCmd($Command) {
            //SSH Login : Beginn
	
			$FernoRaspiIP = $this->ReadPropertyString("GatewayIP");
			$Login = $this->ReadPropertyString("Login");
			$Passwort = $this->ReadPropertyString("Password");
			
			// Debug
			
			print_r($Login);
			print_r($Passwort);
			print_r($FernoRaspiIP);
			print_r($Command);
			

			// Steuercode aus Array holen
			// $code = $FCodeArray[$codeID];

			//print_r($code);
			
			// IP vom Raspberry
			$ssh = new Net_SSH2($FernoRaspiIP);

			//Anmeldeuser und Passwort für Raspberry nach UFT8 konvertieren
			//nur mit UTF8 Einstellung klappt auch ein putty login
			//ohne diese Konvertierung erscheint immer "Login Failed" auch hier per ssh->login
			$username = utf8_encode( $Login );
			$password = utf8_encode( $Passwort );

				if (!$ssh->login($username, $password)) // Hier der echte Login
				{
					exit('Login Failed');
				}
			//SSH Login: Ende


			// Steuercode senden
			//$result = $ssh->exec("sudo ./fernotron-control/FernotronSend ".$code." 3");
			$result = $ssh->exec($Command);

			
			print_r($result);
			
			$ssh->disconnect();
		}
		
		public function TestConnection() {
            //SSH Login : Beginn
	
			$FernoRaspiIP = $this->ReadPropertyString("GatewayIP");
			$Login = $this->ReadPropertyString("Login");
			$Passwort = $this->ReadPropertyString("Password");

			$ssh = new Net_SSH2($FernoRaspiIP);

			//Anmeldeuser und Passwort für Raspberry nach UFT8 konvertieren
			//nur mit UTF8 Einstellung klappt auch ein putty login
			//ohne diese Konvertierung erscheint immer "Login Failed" auch hier per ssh->login
			$username = utf8_encode( $Login );
			$password = utf8_encode( $Passwort );

				if (!$ssh->login($username, $password)) // Hier der echte Login
				{
					$this->SetStatus(201);
					exit('Login Failed');
				}
				else {
					$this->SetStatus(102);
				}
		}
    }
?>