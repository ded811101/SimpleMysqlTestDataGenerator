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
		<h1><a href="./?<?php echo TRIGGER; ?>=table_list">К списку таблиц базы данных: <?php echo $_SESSION['db']['name']; ?></a></h1>
		
		<?php
		$start = $_GET['start'] ? intval($_GET['start']) : 0;
		$rows_number = $_GET['rows_number'] ? intval($_GET['rows_number']) : 100;
		
		$prev=null;
		
		if($start){
			$prev='<a href="./?'.TRIGGER.'=table&table='.$_GET['table'].'&start='.($start-100).'&rows_number=100">предыдущие 100 строк</a> - ';
		}

		echo $prev; echo $next; ?><a href="<?php echo './?'.TRIGGER.'=table&table='.$_GET['table'].'&start='.($start+100).'&rows_number=100'; ?>">следующие 100 строк</a>
		
	<?php
	if(isset($table_rows) && is_array($table_rows) && $table_rows){
		$i=1;
		
		echo '<table class="table_rows">';
			
		echo '<thead>';
		echo '<tr>';
		foreach(current($table_rows) AS $fk=>$fv){
			echo '<td>'.$fk.'</td>';
		}
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		
		foreach($table_rows AS $v){
			
			echo '<tr>';
			
			foreach($v AS $fk=>$fv){
				echo '<td>'.$fv.'</td>';
			}
			
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
	?>
		
</body>
</html>