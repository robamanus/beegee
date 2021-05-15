<?php

	class Pagination{
		
		public $pagination = "";
		
		function __construct($number_of_table_lines,$limit){
			$page = 0; $this->pagination = "<div id='pagination'>";
			for($a=0;$a<$number_of_table_lines;$a++){
				if(($a%$limit == 0)){
					$page++;
					$this->pagination .= "
						<a href='?page=".$page."'>".$page."</a>
					";
				}
			}
			$this->pagination .= "</div>";
			return $this->pagination;
		}
	}
?>