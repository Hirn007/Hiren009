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
		$value=implode("','",$value_arr); //  raj,raj@gmail.com,hello
		
		$ins="insert into $tbl($col) values('$value')"; //'raj','raj@gmail.com','hello'
		$run=$this->conn->query($ins); // query run
		return $run;
		
	}	
		
		
		
	
	
	function update(){
		
	}

	function select_where($tbl,$where){
		
		$sel="select * from $tbl where 1=1"; // query continue
		//$where=array("email"=>$email,"password"=>$password);
		$col_arr=array_keys($where); // array("0"=>"email","1"=>"pasword")
		$value_arr=array_values($where); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($where as $w)
		{
			$sel.=" and $col_arr[$i]='$value_arr[$i]'";
			$i++;
		}
		
		$run=$this->conn->query($sel);// run query
		return $run;
		
		//$chk=$run->num_rows; // ans true or false;   // login
		
		/*
		while($fetch=$run->fetch_object())           // fetch all data which query generate
		{
			$arr[]=$fetch;
		}
		*/
	}
	
	
	
	function delete(){
		
	}
}
?>