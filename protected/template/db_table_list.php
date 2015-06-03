<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Авторизация</title>

		<link rel="stylesheet" rel="stylesheet" href="./css/style.css" />

		<script type="text/javascript" src="./js/script.js"></script>

	</head>
	<body>
		<p><a href="./?<?php echo TRIGGER; ?>=close_connection">Разорвать соединение с базой</a></p>
		<h1><a href="./?<?php echo TRIGGER; ?>=table_list">Список таблиц базы данных: <?php echo $_SESSION['db']['name']; echo ' ('.count($tables_array).')'; ?></a></h1>
		
	<?php
	if(isset($tables_array) && is_array($tables_array) && $tables_array){
		$i=1;
		foreach($tables_array AS $k=>$v){
			?><div><h1><?php echo $i++; ?>. <a href="./?<?php echo TRIGGER; ?>=table&table=<?php echo $k; ?>"><?php echo $k; ?> (<?php echo $v['rows_num']; ?>)</a></h1>
				<form method="POST" action="./?<?php echo TRIGGER; ?>=fill_table&table=<?php echo $k; ?>">
					<input name="rows" type="text" value="1">
					<input name="add" type="submit" value="добавить строки">
				</form>
				<table>
					<thead>
						<tr><?php
						
			foreach(current($v['fields']) AS $fk=>$fv){
				echo '<td>'.$fk.'</td>';
			}
						?></tr>
					</thead>
					<tbody><?php
					
			foreach($v['fields'] AS $fk=>$fv){
				echo '<tr>';
				
				foreach($fv AS $fk1=>$fv1){
		
					echo '<td>'.$fv1.'</td>';
				}
				echo '</tr>';
			}
			?></tbody>
				</table>
			</div><hr/><?php
		}
	}
	?>
		
</body>
</html>