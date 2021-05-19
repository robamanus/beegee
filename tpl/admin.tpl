<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Админ</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta Name="keywords" Content="">
		<meta name="robots" content="noindex, nofollow"/>
		<link rel="stylesheet" type="text/css" href="css/styles.css" />
		<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="js/gikon.js"></script>
		<link rel="shortcut icon" href="img/favicon.ico">
	</head>
	<body>
		<div class="wrapper">
			<div class="container" style='width:100%;'>
				<button id="logout">Логаут</button>
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