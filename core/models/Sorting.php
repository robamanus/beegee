<?php

	class Sorting{
		
		public $sorting;
		
		function __construct($s){
			switch($s){
				case 'sortbyuser': return $this->sorting = 'user_name'; break;
				case 'sortbymail': return $this->sorting = 'email'; break;
				case 'sortbystatus': return $this->sorting = 'status'; break;
				default: return;
			}
		}
	}
?>