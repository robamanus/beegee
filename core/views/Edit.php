<?php

	class Edit{
		
		public function TransformToInput($cl, $v, $str){
			$cl = htmlspecialchars($cl, ENT_QUOTES, 'utf-8');
			$v = htmlspecialchars($v, ENT_QUOTES, 'utf-8');
			$str = htmlspecialchars($str, ENT_QUOTES, 'utf-8');
			echo "<input id='blocked' str='".$str."' type='text' class='".$cl."' value='" . $v . "'><button id='".$cl."'>✔</button>";
		}
	}
		
?>