<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Вход</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta Name="keywords" Content="">
		<meta name="robots" content="noindex, nofollow"/>
		<link rel="stylesheet" type="text/css" href="http://gikon.ru/css/styles.css" />
		<script type="text/javascript" src="http://gikon.ru/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="http://gikon.ru/js/gikon.js"></script>
		<link rel="shortcut icon" href="http://gikon.ru/img/favicon.ico">
	</head>
	<body>
		<div class="wrapper">
			<div class="container">
				<h1>Вход</h1>
				<div class="form">
					<input type="text" placeholder="Username" name="usr">
					<input type="password" placeholder="Password" name="psw">
					<button type="submit" id="login-button">Login</button>
				</div>
				<div class="form" id="task">
					<div><input type="text" placeholder="Юзер" name="user"></div>
					<div><input type="text" placeholder="Почта" name="email"></div>
					<div><textarea type="text" placeholder="Текст задачи" name="task"></textarea></div>
					<div><button type="submit" id="add-task">ОК</button></div>
				</div>
				<div id="sorting">
					<span>Сортировка: </span>
					<span class='sorting' id="sortbyuser">По юзеру</span>
					<span class='sorting' id="sortbymail">По почте</span>
					<span class='sorting' id="sortbystatus">По статусу</span>
				</div>
				<table border='1'>
					<tr id='title'>
						<td>№</td>
						<td>Пользователь</td>
						<td>E-mail</td>
						<td>Текст задачи</td>
						<td>Статус</td>
					</tr>
<?php				
					echo $data;
?>
				</table>
<?php				
					echo $pagination;
?>
			</div>
		</div>
	</body>
</html>