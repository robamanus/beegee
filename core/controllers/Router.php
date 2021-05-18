<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/URL.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/Template.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/Pagination.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/ReadableStatus.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/GuestTable.php";
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/Edit.php";

	class Router{
		
		private $url;
		private $path;
		private $data;
		private $number_of_table_lines;
		private $sortingby;
		private $limit = 3;
		private $admin_strings_limit = 3;
		
		function __construct(){
			$this->url = new Url();
			$db = new DB();
			$this->number_of_table_lines = $db->SelectByQueryString("SELECT COUNT(*) FROM `tasks`", 1);
			$this->number_of_table_lines = $this->number_of_table_lines[0][0];
			if(!isset($_SESSION['page'])) $_SESSION['page'] = 1;
			if(!isset($_SESSION['sorting'])) $_SESSION['sorting'] = 'id';
			$start = $this->limit*($_SESSION['page']-1);
			if(isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin') && ($this->url->request != 'sorting') && ($this->url->request != 'edit') && ($this->url->request != 'confirm') && ($this->url->request != 'logout')) {
				$request = $this->url->request;
				$this->url->request = "admin";
			}
			$desc = "";
			switch($this->url->request){
				default:
					if($this->url->CheckGuestAccess() == true){
						if($this->url->get_method_data[0] != 'page'){
							$this->Page404(); break;
						}
						if((int)$this->url->get_method_data[1] != false){
							$this->path = "index";
						}
						else{
							$this->Page404(); break;
						}
						if(!isset($_SESSION['desc'])) { $_SESSION['desc'] = ""; }
						$this->data = $db->SelectByQueryString("SELECT * FROM `tasks` ORDER BY " . $_SESSION['sorting'] . " " . $_SESSION['desc'] . " LIMIT " . $start . ", " . $this->limit);
						$pagination = new Pagination($this->number_of_table_lines,$this->limit);
						require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/GuestTable.php";
						$rs = new ReadableStatus($this->data);
						$this->data = $rs->data;
						$gt = new GuestTable($this->data);
						$this->data = $gt->table_data;
						$template = new Template($this->path,$this->data,$pagination->pagination);
						break;
					}
					else{
						$this->Page404(); break;
					}
				case false:
				$this->path = "index";
					require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/Sorting.php";
					if(!isset($_SESSION['sorting'])) { $_SESSION['sorting'] = "id"; }
					if(!isset($_SESSION['desc'])) { $_SESSION['desc'] = ""; }
					$this->data = $db->SelectByQueryString("SELECT * FROM `tasks` ORDER BY " . $_SESSION['sorting'] . " " . $_SESSION['desc'] . " LIMIT " . $start . ", " . $this->limit);
					$pagination = new Pagination($this->number_of_table_lines,$this->limit);
					$rs = new ReadableStatus($this->data);
					$this->data = $rs->data;
					require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/GuestTable.php";
					$gt = new GuestTable($this->data);
					$this->data = $gt->table_data;
					$template = new Template($this->path,$this->data,$pagination->pagination);
					break;
				case 'add-task':
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
						if(($_POST['user'] != false) && ($_POST['email'] != false) && ($_POST['text'] != false)){
							$_POST['user'] = htmlspecialchars($_POST['user']);
							$_POST['email'] = htmlspecialchars($_POST['email']);
							$_POST['text'] = htmlspecialchars($_POST['text']);
							if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email'])){
								echo "Неверный формат почты"; return;
							}
							require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/DB.php";
							$new_task = array($_POST['user'],$_POST['email'],$_POST['text']);
							$cells = array("user_name","email","task_text");
							$db = new DB();
							if($db->InsertData("tasks",$new_task,$cells)){
								echo "Задача добавлена!";
							}
						}
						else return;
					}
					break;
				case 'sorting':
					if(isset($_POST['sorting'])){
						require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/Sorting.php";
						$this->sortingby = new Sorting($_POST['sorting']);
						if(!isset($_SESSION['sorting'])) { $_SESSION['sorting'] = "id"; }
						if(!isset($_SESSION['desc'])) { $_SESSION['desc'] = ""; }
						if($_SESSION['sorting'] == $this->sortingby->sorting){
							switch($_SESSION['desc']){
								case "": $_SESSION['desc'] = "DESC"; break;
								case "DESC": $_SESSION['desc'] = ""; break;
								default: $_SESSION['desc'] = ""; break;
							}
						}
						$_SESSION['sorting'] = $this->sortingby->sorting;
						
						$this->data = $db->SelectByQueryString("SELECT * FROM `tasks` ORDER BY " . $this->sortingby->sorting . " " . $_SESSION['desc'] . " LIMIT " . $start . ", " . $this->limit);
						$rs = new ReadableStatus($this->data);
						$this->data = $rs->data;
						require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/GuestTable.php";
						$gt = new GuestTable($this->data);
						echo $gt->table_data;
					}
					break;
				case 'login':
					if(isset($_POST['usr']) && (is_string($_POST['usr'])==true) && (isset($_POST['psw'])) && (is_string($_POST['psw'])==true)){
						require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/models/Admin.php";
						$adm = new Admin();
						$_POST['usr'] = htmlspecialchars($_POST['usr']);
						$_POST['psw'] = htmlspecialchars($_POST['psw']);
						$l = $_POST['usr'];
						$p = $_POST['psw'];
						$adm->Login($l,$p);
					}
					else{
						die("Неправильно!");
					}
					break;
				case 'edit':
					if(isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin') && ($this->url->request != 'sorting') && ($this->url->request != 'confirm')) {
						if(isset($_POST['cl']) && (is_string($_POST['cl'])==true) && (isset($_POST['v'])) && (is_string($_POST['v'])==true) && isset($_COOKIE['hash']) && ($_COOKIE['hash'] == '80df2f82439863ad5193befb645911ea') && (isset($_COOKIE['login'])) && ($_COOKIE['login'] == 'admin') && ($this->url->request != 'sorting')){
							$edit = new Edit();
							$input = $edit->TransformToInput($_POST['cl'],$_POST['v'],$_POST['str']);
						}
						else{
							header("Refresh:0");
						}
					}
					else{
						echo false;
					}
					break;
				case 'confirm':
					if(isset($_POST['input_data']) && (is_string($_POST['input_data'])==true) && isset($_POST['input_data']) && (is_string($_POST['v'])==true) && (isset($_POST['i']))){
						$_POST['input_data'] = htmlspecialchars($_POST['input_data'], ENT_QUOTES, 'utf-8');
						$_POST['v'] = htmlspecialchars($_POST['v'], ENT_QUOTES, 'utf-8');
						$_POST['str'] = htmlspecialchars($_POST['str'], ENT_QUOTES, 'utf-8');
						$_POST['i'] = htmlspecialchars($_POST['i'], ENT_QUOTES, 'utf-8');
						if(strpos($_POST['str'],"email") !== false) $column = 'email';
						if(strpos($_POST['str'],"task") !== false) $column = 'task_text';
						if(strpos($_POST['str'],"usr") !== false) $column = 'user_name';
						if($db->UpdateData("UPDATE `tasks` SET `".$column."`='".$_POST['input_data']."', `status`=2 WHERE `".$column."`='".$_POST['v']."' AND id=".$_POST['i'])){
							echo "обновлено!";
						}
					}
					else{
						header("Refresh:0");
					}
					break;
				case 'admin':
					if($this->url->CheckAdminAccess() === false){
						$this->Page404(); break;
					}
					else{
						$this->path = "admin";
					}
					require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "core/views/AdminTable.php";
					$pagination = new Pagination($this->number_of_table_lines,$this->limit);
					$this->data = $db->SelectByQueryString("SELECT * FROM `tasks` ORDER BY " . $_SESSION['sorting'] . " " . $_SESSION['desc'] . " LIMIT " . $start . ", " . $this->admin_strings_limit);
					$rs = new ReadableStatus($this->data);
					$this->data = $rs->data;
					$at = new AdminTable($this->data);
					$this->data = $at->table_data;
					$template = new Template($this->path,$this->data,$pagination->pagination);
					break;
				case 'logout':
					setcookie("login","",time()-31536000,'/');
					setcookie("hash","",time()-31536000,'/');
					break;
			}
		}
		function Admin(){
			$this->path = "admin";
			new Template($this->path,$this->data);
		}
		function Page404(){
			$this->path = "404";
			new Template($this->path,$this->data);
		}
	}
?>