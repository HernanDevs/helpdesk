<?php
    session_start();
    class conectar{
        protected $dbh;

        protected function Conexion(){
            try {

                //LOCAL
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=jsoncode_helpdesk","root","");
                
                //PRODUCCION
				//$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=dbuzge4qv8ygsv","","");

				return $conectar;	
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();	
			}
        }

        public function set_names(){	
			return $this->dbh->query("SET NAMES 'utf8'");
        }
        
        public static function ruta(){

            //LOCAL
			    return "http://localhost:80/PERSONAL_HelpDesk/";

            //produccion
            //return "http://jsons.tel/";
		}

    }
?>