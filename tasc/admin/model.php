<?php

class model{
	
	public $conn;
	function __construct()
	{
		$this->conn = new mysqli("localhost", "root", "", "fast_food");
		echo "My name is Model";
	}
	
function select($tbl){
		
		$sel="select * from $tbl";  
		$run=$this->conn->query($sel);    
		while($fetch=$run->fetch_object())           
		{
			$arr[]=$fetch;
		}
		return $arr;
	} 
	
	function insert($tbl,$arr){ 
		
		$key=array_keys($arr); 
		$col=implode(",",$key); 
		
		$value_arr=array_values($arr); 
		$value=implode("','",$value_arr); 
		
		echo $ins="insert into $tbl($col) values('$value')"; 
		$run=$this->conn->query($ins); 
		return $run;
		
	}	
	
}
?>