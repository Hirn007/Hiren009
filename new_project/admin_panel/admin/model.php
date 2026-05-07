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
		$arr = array();
		while($fetch=$run->fetch_object())           // fetch all data which query generate
		{
			$arr[]=$fetch;
		}
		return $arr;
	} 
function insert($tbl, $arr){
    $columns = implode(",", array_keys($arr));
    $values = array_map([$this->conn, 'real_escape_string'], array_values($arr));
    $values = "'" . implode("','", $values) . "'";
    
    $sql = "INSERT INTO $tbl ($columns) VALUES ($values)";
    return $this->conn->query($sql);
}

		
		
		
	
	
	function update($tbl,$arr,$where){
		
		$set = "";
		$col_arr=array_keys($arr); // array("0"=>"email","1"=>"pasword")
		$value_arr=array_values($arr); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($arr as $w)
		{
			$set.="$col_arr[$i]='$value_arr[$i]',";
			$i++;
		}
		$set = rtrim($set,',');
		
		$sel="update $tbl set $set where 1=1"; // query continue
		//$where=array("email"=>$email,"password"=>$password);
		$col_arr_where=array_keys($where); // array("0"=>"email","1"=>"pasword")
		$value_arr_where=array_values($where); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($where as $w)
		{
			$sel.=" and $col_arr_where[$i]='$value_arr_where[$i]'";
			$i++;
		}
		
		$run=$this->conn->query($sel);// run query
		return $run;
		
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
	
	
	
	function delete($tbl, $where){
		$sel="delete from $tbl where 1=1"; // query continue
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
	}
}
?>