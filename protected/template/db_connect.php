<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Подключение к базе данных</title>

		<link rel="stylesheet" rel="stylesheet" href="./css/style.css" />

		<script type="text/javascript" src="./js/script.js"></script>

	</head>
	<body>
		<div class="error1"><?php echo $this->error; ?></div>
		<div class="login_block">
			<h1>Подключение к базе данных</h1>
			<form method="post" action="./">
			<ul class="for_form">
				<li class="pad_20 b">Хост</li>
				<li><input name="db[host]" type="text" class="grid_325 log_in" value="localhost" autofocus/></li>
				<li class="b">Пользователь</li>
				<li><input name="db[user]" type="text" class="grid_325 log_in" value=""/></li>
				<li class="b">Пароль</li>
				<li><input name="db[password]" type="text" class="grid_325 log_in" value=""/></li>
				<li class="b">Имя базы данных</li>
				<li><input name="db[name]" type="text" class="grid_325 log_in" value=""/></li>
				<li class="b">Порт</li>
				<li><input name="db[port]" type="text" class="grid_325 log_in" value=""/></li>
				<li class="b">Сокет</li>
				<li><input name="db[socket]" type="text" class="grid_325 log_in" value=""/>
					<input class="submit" name="db_connect" value="войти" title="" type="submit"/>
				</li>
			</ul>
		</form>
	</div>
</body>
</html>