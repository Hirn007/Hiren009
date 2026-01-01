<?php

class model{
	
	public $conn;
	function __construct()
	{
		$this->conn = new mysqli("localhost", "root", "", "coffe_shope");
	}
	
function select($tbl){
		
		$sel="select * from $tbl";  // query generate
		$run=$this->conn->query($sel);    // query run of db
		while($fetch=$run->fetch_object())           // fetch all data which query generate
		{
			$arr[]=$fetch;
		}
		return $arr;
	} 
		
	function insert($tbl,$arr){ //$arr=array("name"=>$name,"email"=>$email,"comment"=>$comment);
			
		$key=array_keys($arr); // $key=array("name","email","comment")
		$col=implode(",",$key); //  "name","email","comment"
			
		$value_arr=array_values($arr); // $value=array($name,$email,$comment)
		$value=implode(",",$value_arr); //  raj,raj@gmail.com,hello
			
		echo $ins="insert into $tbl($col) values($value)"; //'raj','raj@gmail.com','hello'
		$run=$this->conn->query($ins); // query run
		return $run;
			
	}	
		
		
		
	
	
	function update(){
		
	}

	function select_where(){
		
		
	}
	
	
	function delete(){
		
	}
}
?>