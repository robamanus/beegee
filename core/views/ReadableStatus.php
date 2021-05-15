<?php

	class ReadableStatus{
		
		public $data;
		
		function __construct($data){
			for($a=0;$a<count($data);$a++){
				switch((int)$data[$a]['status']){
					case false: $data[$a]['status'] = 'Не выполнена'; break;
					case 1:  $data[$a]['status'] = 'Выполнена'; break;
					case 2:
						if(isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin')) {
							$data[$a]['status'] = 'Выполнена и отредактировано администратором'; break;
						}
						else {
							$data[$a]['status'] = 'Выполнена'; break;
						}
					default: break;
				}
			}
			$this->data = $data;
		}
	}
?>