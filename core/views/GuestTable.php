<?php

	class GuestTable{
		
		public $table_data = "";
		
		function __construct($data){
			for($a=0;$a<count($data);$a++){
					$this->table_data .= "
					<tr class='task_table'>
						<td>" . ($a+1) . "</td>
						<td>" . $data[$a]['user_name'] . "</td>
						<td>" . $data[$a]['email'] . "</td>
						<td>" . $data[$a]['task_text'] . "</td>
						<td>" . $data[$a]['status'] . "</td>
					</tr>
					";
			}
			return $this->table_data;
		}
	}
?>