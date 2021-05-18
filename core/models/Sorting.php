<?php

	class Sorting{
		
		public $sorting;
		
		function __construct($s){
			switch($s){
				case 'sortbyuser': $this->sorting = 'user_name'; break;
				case 'sortbymail': $this->sorting = 'email'; break;
				case 'sortbystatus': $this->sorting = 'status'; break;
				default: $this->sorting = 'id'; break;
			}
		}
	}
?>