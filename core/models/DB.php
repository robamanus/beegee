<?php

	class DB{
		
		public $db_host = "localhost";
		private $db_user = 'ck35313_gikonru';
		private $db_password = 'x5x5x5x5';
		private $db_name = "ck35313_gikonru";
		private $db_connect;
		static $cell;
		
		
		private function CreateDBConnect(){
			$this->db_connect = new Mysqli(($this->db_host),($this->db_user),($this->db_password),($this->db_name));
			$this->db_connect->query("SET NAME 'utf8'");
			if (mysqli_connect_errno()) {
				printf("Ошибка соединения: %s\n", mysqli_connect_error());
				exit();
			}
			return $this->db_connect;
		}
		public function DBC(){
			$this->CreateDBConnect();
		}
		public function SelectByQueryString($string, $fetch_array = false){
			$this->DBC();
			$q = $this->db_connect->query($string);
			if(isset($q->num_rows)) {
				switch($fetch_array){
					case false: while($a = $q->fetch_assoc()) {
									$values[] = $a;
								}
								break;
					case true: while($a = $q->fetch_array()) {
									$values[] = $a;
								}
								break;
				}
				
				$this->MsqlClose();
				if(isset($values)) { return $values; }
				else return;
			}
			$this->MsqlClose();
			return;
		}
		public function MsqlClose(){
			if($this->db_connect) { $this->db_connect->close(); }
		}
		public function InsertData($table=false,$data=false,$cell=false){
			$generate_query = "INSERT INTO ".$table." (";
			if($cell!=false){
				foreach($cell as $key=>$value){
					$generate_query .= $value;
					if(!next($cell)) $generate_query .= "";
					else $generate_query .= ",";
				}
			}
			$generate_query .= ") VALUES (";
			if($data!=false){
				foreach($data as $key=>$value){
					$generate_query .= "'";
					$generate_query .= $value;
					$generate_query .= "'";
					if(!next($data)) $generate_query .= "";
					else $generate_query .= ",";
				}
			}
			$generate_query .= ')';
			$this->DBC();
			if($insert = $this->db_connect->query($generate_query)) {
				return true;
			}
			$this->MsqlClose();
		}
		public function UpdateData($query){
			$this->DBC();
			$u = $this->db_connect->query($query);
			$this->MsqlClose();
			return $u;
		}
	}
?>