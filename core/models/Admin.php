<?php
	
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';

	class Admin{
		
		public $stop = "st0p";
		private $salt_psw = "tfjuyfgk";
		private $enter_code = "5hhrtytj34yrg45yhh5";
		
		public function Login($l,$p){
			$act = false;
			$db = new DB();
			$l = strtolower($l);
			$l = $l;
			$p = md5($p.($this->salt_psw));
			$data = $db->SelectByQueryString("SELECT * FROM `account_data` WHERE login='".$l."' AND psw='".$p."'");
			if($data!=false) {
				setcookie("login", $l, time() + 30000, '/');
				setcookie("hash", $p, time() + 30000, '/');
				$act = 1;
			}
			else{
				echo "Неправильно!";
			}
			echo $act;
		}
	}
	
?>