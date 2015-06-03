<?php

class FieldSetClass{
	private $field_object_array=null;

	function __construct(){}
	
	function AddField($field_object){
		$this->field_object_array[]=$field_object;
	}
	
	function GetFieldObjectArray(){
		return $this->field_object_array;
	}
}