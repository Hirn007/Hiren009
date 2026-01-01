<?php

class model{
	
	public $conn;
	function __construct()
	{
		$this->conn = new mysqli("localhost", "root", "", "coffe_shope");
	}
	
function select($table)
{
    $sql = "SELECT * FROM $table";
    $run = $this->conn->query($sql);

    while($fetch=$run->fetch_object())
    {
        $arr[] = $fetch;
    }
    return $arr;
}
		
	function insert($table, $arr)
{
    $columns = implode(",", array_keys($arr));
    $values  = implode("','", array_values($arr));

    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

    $run = $this->conn->query($sql);
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