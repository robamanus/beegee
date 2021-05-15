<?php

	class Url{
		
		public $request;
		public $get_method_data;
		public $separator = "/";
		private $admin_access = false;
		private $guest_access = false;
		
		function __construct(){
			
			$this->request = $_SERVER["REQUEST_URI"];
			$this->request = $this->ProcessingRequest($this->request);
			if (strpos($this->request, "?") !== false) {
				$this->exrequest = explode('?', $this->request);
				$this->get_method_data = explode('=', $this->exrequest[1]);
				if($this->get_method_data[0] == 'page'){
					$_SESSION['page'] = (int)($this->get_method_data[1]);
					if(isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin')){
						$this->admin_access = true;
					}
					else{
						$this->guest_access = true;
					}
				}
			}
			else{
				if(isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin') && ($this->request == false)){
					$this->admin_access = true;
				}
				else{
					$this->guest_access = true;
				}
				$this->exrequest = $this->request;
			}
			return $this->exrequest;
		}
		public function CheckAdminAccess(){
			return $this->admin_access;
		}
		public function CheckGuestAccess(){
			return $this->guest_access;
		}
		public function ProcessingRequest($req){
			$req = substr_replace($req, "", 0, 1);
			return $req;
		}
	}
?>