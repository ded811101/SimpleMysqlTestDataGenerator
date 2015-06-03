<?php

class FieldClass{
	private $field=null;
	private $type=null;
	private $length=null;
	private $null=null;
	private $key=null;
	private $default=null;
	private $extra=null;

	function __construct($field_array=null){
		
		$this->field=$field_array['Field'];
		
		sscanf($field_array['Type'], "%[a-zA-Z](%[0-9])", $this->type, $this->length);
						
		$this->null=$field_array['Null'];
		$this->key=$field_array['Key'];
		$this->default=$field_array['Default'];
		$this->extra=$field_array['Extra'];
	}
	
	function GetField(){
		return $this->field;
	}
	
	function GetType(){
		return $this->type;
	}
	
	function GetLength(){
		return $this->length;
	}
	
	function GetNull(){
		return $this->null;
	}
	
	function GetKey(){
		return $this->key;
	}
	
	function GetDefault(){
		return $this->default;
	}
	
	function GetExtra(){
		return $this->extra;
	}
	
}