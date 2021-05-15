<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/models/URL.php";

	class Template{
		
		function __construct($path,$data,$pagination=false){
			switch ($path){
				case 'index': $this->IndexPage($data,$pagination); break;
				case 'admin': $this->Admin($data,$pagination); break;
				default: $this->Page404(); break;
			}
		}
		public function IndexPage($data,$pagination){
			require_once "tpl/index.tpl";
		}
		public function Admin($data,$pagination){
			require_once $_SERVER['DOCUMENT_ROOT'] . "/tpl/admin.tpl";
		}
		public function Page404(){
			require_once $_SERVER['DOCUMENT_ROOT'] . "/tpl/404.tpl";
		}
	}
?>