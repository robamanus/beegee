<?php

	class AdminTable{
		
		public $table_data = "";
		
		function __construct($data){
			for($a=0;$a<count($data);$a++){
					$this->table_data .= "
					<tr class='task_table'>
						<td>" . ($a+1) . "</td>
						<td i='".$data[$a]['id']."' class='usr_adm' str='usr_adm". ($a+1) ."'>" . $data[$a]['user_name'] . "</td>
						<td i='".$data[$a]['id']."' class='email_adm' str='email_adm". ($a+1) ."'>" . $data[$a]['email'] . "</td>
						<td i='".$data[$a]['id']."' class='task_text_adm' str='task_text_adm". ($a+1) ."'>" . $data[$a]['task_text'] . "</td>
						<td i='".$data[$a]['id']."' class='status_adm' str='status_adm". ($a+1) ."'>" . $data[$a]['status'] . "</td>
					</tr>
					";
			}
			return $this->table_data;
		}
	}
?>