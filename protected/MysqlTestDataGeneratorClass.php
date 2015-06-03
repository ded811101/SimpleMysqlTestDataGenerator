<?php

require_once 'FieldClass.php';
require_once 'FieldSetClass.php';
require_once 'DataBuilder.php';


class MysqlTestDataGeneratorClass{

	private $mysqli=null;

	private $error=null;

	function __construct($language=null){}

	function run(){
		session_start();

		//есть данные в сессии для подключения
		if(isset($_SESSION['db'])){
			//данные корректны
			if($this->ConnectToDB($_SESSION['db'])){

				$trigger=isset($_GET[TRIGGER]) ? $_GET[TRIGGER] : 'table_list';

				switch ($trigger) {

					case 'close_connection':
						unset($_SESSION['db']);
						require_once "./protected/template/db_connect.php";
						break;

					case 'table_list':
						$this->ShowDBTableList();
						break;

					case 'table':
						$this->ShowTable();
						break;

					case 'fill_table':
						if($_POST){
							$this->FillTable($_POST['rows']);
						}

						$this->ShowTable();
						break;

					default:
						require_once "./protected/template/db_connect.php";
				}
			}

		}else{
			//нет данных в сессии для подключения

			//была отправка из формы
			if($_POST['db_connect']){

				//успешно соединились
				if($this->ConnectToDB($_POST['db'])){
					$_SESSION['db']=$_POST['db'];
					$this->ShowDBTableList();
					return true;
				}
			}

			//показываем форму
			require_once "./protected/template/db_connect.php";
		}

		return true;
	}

	//подключаемся кбазе помассиву параметров
	function ConnectToDB($data){
		if(empty($data['host']) || empty($data['user']) || empty($data['name'])){
			$this->error='не указаны сервер, имя пользователя или имя базы данных';

			return false;
		}

		if(empty($data['port'])){
			$data['port']=null;
		}

		if(empty($data['socket'])){
			$data['socket']=null;
		}

		$this->mysqli=new mysqli($data['host'],$data['user'],$data['password'],$data['name'],$data['port'],$data['socket']);

		if (mysqli_connect_errno()) {
			$this->error= "Подключение к серверу MySQL невозможно. Код ошибки: %s\n".mysqli_connect_error();
			return false;
		}

		$this->mysqli->query("SET NAMES ".ENCODING_DB);
		return true;
	}


	//список таблиц
	function ShowDBTableList(){
		$result=$this->mysqli->query('SHOW TABLES');

		//массив таблиц
		$tables_array=array();

		//поля
		$finfo = $result->fetch_field_direct(0);

		while($row = $result->fetch_assoc()){

			//колличество записей в таблице
			$result2=$this->mysqli->query('SELECT COUNT(*) rows_num FROM `'.$row[$finfo->name].'`');

			$row2 = $result2->fetch_assoc();

			$result2->close();

			$field_array=array('rows_num'=>$row2['rows_num']);

			$field_array['fields']=$this->GetTableInfo($row[$finfo->name]);

			$tables_array[$row[$finfo->name]]=$field_array;
		}

		// Освобождаем память
		$result->close();

		require_once "./protected/template/db_table_list.php";
	}

	//просматриваем содержимое таблицы
	function ShowTable(){
		$start = $_GET['start'] ? intval($_GET['start']) : 0;
		$rows_number = $_GET['rows_number'] ? intval($_GET['rows_number']) : 100;

		if(isset($_GET['table'])){

			$table=mysql_escape_string($_GET['table']);

			$result=$this->mysqli->query('SELECT * FROM `'.$table.'` LIMIT '.$start.', '.$rows_number);

			$table_rows = $result->fetch_all(MYSQLI_ASSOC);

			$result->close();

		}

		require_once "./protected/template/db_show_table.php";
	}

	//заполняем таблицу
	function FillTable($rows){
		if(isset($_GET['table'])){

			$table=mysql_escape_string($_GET['table']);

			$table_info=$this->GetTableInfo($table);

			$this->CreateFillTableRequest($table, $table_info, $rows);
		}
	}
	
	function CreateFillTableRequest($table, $table_info, $rows){
		if($rows==0){
			return false;
		}

		$sql="INSERT INTO `".$table."` (";

		$comma=null;

		$field_set=new FieldSetClass;

		foreach($table_info AS $k=>$v){

			//если автоинкримент то пропускаем
			if($v['Extra']=="auto_increment"){
				continue;
			}

			$sql.=$comma."`".$v['Field']."`";

			if(is_null($comma)){
				$comma=", ";
			}

			$field_set->AddField(new FieldClass($v));
		}

		$sql.=") VALUES ";


		//колличество ошибок
		$error=0;
		$builder = new DataBuilder();

		for($i=1;$i<=$rows;$i++){
			do{
				$result=$this->mysqli->real_query($sql.$builder->GenerateData($field_set->GetFieldObjectArray()));
			}while(!$result);
		}
	}

	//информация о полях таблицы
	function GetTableInfo($table_name){
		$field_array=array();

		$result=$this->mysqli->query('DESCRIBE `'.$table_name.'`');

		while($row = $result->fetch_assoc()){
			$field_array[]=$row;
		}

		$result->close();

		return $field_array;
	}
}